using UnityEngine;
using System.Collections;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
using System.Collections.Generic;

public class UIMenuPrincipal : MonoBehaviour {

	public Indices indice;
    
	//login do usuario
	public Animator painelPrincipal;
	public InputField login;
    public InputField senha;
	ObjetoUsuario usuarioLogado = new ObjetoUsuario();

	//escolha do projeto
	public Animator painelEscolhaProj;

	//painel de erro
	public Text mensagemErro;
	public Animator painelErro;

	//painel dos projetos
	string idPROJETOS;
	string nomeProjeto;
	string textoProjeto;
	string tipoProjeto;
	string usuarioProjeto;
	string acessoProjeto;

	public Animator painelProjetosPub;
	public List <ObjetoProjeto> projetosPublicos = new List<ObjetoProjeto>();
	public List <GameObject> btProjetosPublicos = new List<GameObject>();

	public Animator painelProjetosPri;
	public List <ObjetoProjeto> projetosPrivados = new List<ObjetoProjeto>();
	public List <GameObject> btProjetosPrivados = new List<GameObject>();

	public Sprite btSelecionado;
	public Sprite btDesSelecionado;

	bool projetoPublicoSelecionado = false;
	bool projetoPrivadoSelecionado = false;

    void Start () {
		if (GameObject.Find ("Indices")) {
			indice = GameObject.Find ("Indices").GetComponent<Indices> ();
		}else if (indice == null) {
			GameObject i = Instantiate(Resources.Load("Indices")) as GameObject;
			i.name = "Indices";
			indice = i.GetComponent<Indices>();
		} 
	}
	
	void Update () {
		//para sair do app
		if (Input.GetKeyDown (KeyCode.Escape)) {
			Application.Quit ();
		}
        /* para testes
		if(indice.GetComponent<JSONLeituraProjeto>().terminouDeCarregarObjetos){
			chamaRealidadeAumentada ();
			indice.GetComponent<JSONLeituraProjeto> ().terminouDeCarregarObjetos = false;
		}
        */
	}

	//controle das aniamõçoes
	public void saiPainelPrincipal(){
		painelPrincipal.SetBool ("entra", false);
		painelPrincipal.SetBool ("sai", true);
	}

	public void entraPainelPrincipal(){
		painelPrincipal.SetBool ("entra", true);
		painelPrincipal.SetBool ("sai", false);
	}

	public void saiPainelErro(){
		painelErro.SetBool ("sai", true);
		painelErro.SetBool ("entra", false);
	}

	public void EntraPainelErro(){
		painelErro.SetBool ("sai", false);
		painelErro.SetBool ("entra", true);
	}

	public void saiPainelProjetosPub(){
		projetoPublicoSelecionado = false;
		projetoPrivadoSelecionado = false;
		painelProjetosPub.SetBool ("sai", true);
		painelProjetosPub.SetBool ("entra", false);
		entraPainelEscolhaProj ();
	}

	public void entraPainelProjetosPub(){
		painelProjetosPub.SetBool ("entra", true);
		painelProjetosPub.SetBool ("sai", false);
		saiPainelEscolhaProj();

	}

	public void saiPainelProjetosPri(){
		projetoPublicoSelecionado = false;
		projetoPrivadoSelecionado = false;
		painelProjetosPri.SetBool ("sai", true);
		painelProjetosPri.SetBool ("entra", false);
		entraPainelEscolhaProj ();
	}

	public void entraPainelProjetosPri(){
		painelProjetosPri.SetBool ("entra", true);
		painelProjetosPri.SetBool ("sai", false);
		saiPainelEscolhaProj ();
	}

	public void entraPainelEscolhaProj(){
		painelEscolhaProj.SetBool ("entra", true);
		painelEscolhaProj.SetBool ("sai", false);
		saiPainelPrincipal();
	}

	public void saiPainelEscolhaProj(){
		painelEscolhaProj.SetBool ("sai", true);
		painelEscolhaProj.SetBool ("entra", false);
	}
		
	//acesso ao banco e preenchimento dos dados dos paineis
    public void logando(){
        StartCoroutine(logar(login.text, senha.text));
    }

    IEnumerator logar(string l, string s){
		string urlLeitura = indice.url+"log/"+ l+"/"+ s;
		//Debug.Log(urlLeitura);
        WWW www = new WWW(urlLeitura);
        yield return www;
        if (!string.IsNullOrEmpty(www.error)){
            Debug.Log("Error : " + www.error);
			mensagemErro.text = "Login ou senha inválidos, favor verificar.";
			EntraPainelErro();
			login.text = "";
			senha.text = "";
        }else {
            // resposta do servidor. Note que se der erro no banco de dados, vai entrar aqui.
            // O php precisa printar os erros para aprecer aqui
           // Debug.Log(urlLeitura);
			string[] divisao = www.text.Split ('"');

			if (divisao.Length == 1) {
				mensagemErro.text = "Login ou senha inválidos, favor verificar.";
				EntraPainelErro();
				login.text = "";
				senha.text = "";
			} else {
				
				//{"idUSUARIOS":"1","nome":"THIAGO ZAMBORLINI FRAGA","usuario":"t","senha":"t","email":"thiagozamborlini@gmail.com","ativo":"0","nivel":"3","data":"Wed, 05 Oct 16 22:11:14 +0000","obs":"t","GRUPOS_idGRUPOS":"1"}

				usuarioLogado.idUSUARIOS = divisao [3];
				usuarioLogado.nome = divisao [11];
				usuarioLogado.usuario = divisao [19];
				usuarioLogado.senha = divisao [27];
				usuarioLogado.email = divisao [35];
				usuarioLogado.GRUPOS_idGRUPOS = divisao [75];

				indice.usuarioLogado = this.usuarioLogado;

				entraPainelEscolhaProj();
				saiPainelPrincipal ();
			}
        }
    }

	public void carregaProjetosPub(){
		entraPainelProjetosPub ();
		saiPainelEscolhaProj ();
		StartCoroutine(indice.GetComponent<JSONLeituraProjeto>().carregaProjetosPublicos());
	}

	public void carregaProjetosPri(){
		entraPainelProjetosPri ();
		saiPainelEscolhaProj ();
		StartCoroutine(indice.GetComponent<JSONLeituraProjeto>().carregaProjetosPublicos());
		StartCoroutine(indice.GetComponent<JSONLeituraProjeto>().carregaProjetosPrivados(usuarioLogado.idUSUARIOS));
	}

	public void selecionaProjeto(GameObject g){
		//Debug.Log ("certo? "+g.name);
		if (g.GetComponent<BtProjeto> ().projeto.acessoProjeto == "publico") {
			for (int i = 0; i < btProjetosPublicos.Count; i++) {
				if (g.name == btProjetosPublicos [i].name) {
					g.GetComponent<Image> ().sprite = btSelecionado;
					g.transform.GetChild (0).GetComponent<Text> ().color = Color.blue;

					GameObject.Find ("Txt Projetos pub Descri conteudo").GetComponent<Text> ().text = g.GetComponent<BtProjeto>().projeto.textoProjeto;
					
					indice.projeto = g.GetComponent<BtProjeto>().projeto;
				} else {
					btProjetosPublicos [i].GetComponent<Image> ().sprite = btDesSelecionado;
					btProjetosPublicos [i].transform.GetChild (0).GetComponent<Text> ().color = Color.white;
				}
			}
		} else {
			for (int i = 0; i < btProjetosPrivados.Count; i++) {
				if (g.name == btProjetosPrivados [i].name) {
					g.GetComponent<Image> ().sprite = btSelecionado;
					g.transform.GetChild (0).GetComponent<Text> ().color = Color.blue;
					GameObject.Find ("Txt Projetos Descri conteudo").GetComponent<Text> ().text = g.GetComponent<BtProjeto>().projeto.textoProjeto;
					indice.projeto = g.GetComponent<BtProjeto> ().projeto;
				} else {
					btProjetosPrivados[i].GetComponent<Image> ().sprite = btDesSelecionado;
					btProjetosPrivados[i].transform.GetChild (0).GetComponent<Text> ().color = Color.white;
				}
			}
		}
	}
		
	public void criaBtProjeto (ObjetoProjeto projeto){

		if (projeto.acessoProjeto == "publico") {
			if(projetoJaNaListaBt("publico", projeto.nomeProjeto)){
				GameObject projetoBt = (GameObject) Instantiate(Resources.Load("Bt itemLista Projetos"));
				projetoBt.name = projeto.nomeProjeto;
				projetoBt.transform.GetChild(0).GetComponent<Text>().text = projeto.nomeProjeto;

				//Debug.Log("dentro do menu: "+projeto.textoProjeto);

				projetoBt.GetComponent<BtProjeto> ().projeto = projeto;
				projetoBt.transform.parent= GameObject.Find ("Conteudo proj publico").transform;
				projetoBt.transform.localScale = Vector3.one;
				btProjetosPublicos.Add (projetoBt);
			}
			projetoPublicoSelecionado = true;
			projetoPrivadoSelecionado = false;
		}
		if (projeto.acessoProjeto == "privado") {
			if (projetoJaNaListaBt ("privado", projeto.nomeProjeto)) {
				GameObject projetoBt = (GameObject)Instantiate (Resources.Load ("Bt itemLista Projetos"));
				projetoBt.name = projeto.nomeProjeto;
				projetoBt.transform.GetChild (0).GetComponent<Text> ().text = projeto.nomeProjeto;
				projetoBt.GetComponent<BtProjeto> ().projeto = projeto;
				projetoBt.transform.parent = GameObject.Find ("Conteudo proj Privado").transform;
				projetoBt.transform.localScale = Vector3.one;
				btProjetosPrivados.Add (projetoBt);
			}
			projetoPublicoSelecionado = false;
			projetoPrivadoSelecionado = true;
		}
	}

	public bool projetoJaNaListaBt(string acesso, string nome){
		bool resultado = true;
		if (acesso == "publico") {
			for (int i = 0; i < btProjetosPublicos.Count; i++) {
				if (btProjetosPublicos [i].transform.GetChild (0).GetComponent<Text> ().text == nome) {
					resultado = false;
				}
			}
		}
		if (acesso == "privado") {
			for (int i = 0; i < btProjetosPrivados.Count; i++) {
				if (btProjetosPublicos [i].transform.GetChild (0).GetComponent<Text> ().text == nome) {
					resultado = false;
				}
			}
		}
		return resultado;
	}

	public void acessaCenaProjeto(){
		if (indice.projeto.idPROJETOS == "") {
			painelErro.SetBool ("entra", true);
			painelErro.SetBool ("sai", false);
			mensagemErro.text = "É necessário escolher 1 projeto.";
		} else {
            chamaRealidadeAumentada();
        }
	}

    //chamada para mudança de cena
    public void chamaRealidadeAumentada(){
		indice.qualCenaChamar = "Realidade Aumentada";
		SceneManager.LoadScene ("Loading");
	}

	public void chamaVirtualidadeAumentada(){
		//AsyncOperation async = Application.LoadLevelAsync ("Virtualidade Aumentada" );
		indice.qualCenaChamar = "Virtualidade Aumentada";
		SceneManager.LoadScene ("Loading");
	}
}
