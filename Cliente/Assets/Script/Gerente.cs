using UnityEngine;
using System.Collections;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
using Vuforia;
using System.Collections.Generic;

public class Gerente : MonoBehaviour {

	//Essa é a posição da camera move, sua é importate para a posição dos POIs
	public Camera camera;//essa é a cameraMove

	public Indices indice;

	//UI
	public Text textoDebug;
	public Text mensagem;
	public Animator painelMensagem;
	public InputField obsFeedback;
	public GameObject painelColisao;
	public Text textoDaPosColisao;
    public Text informativo;
    public GameObject painelInformativo;
	public GameObject quemManipulouPainelInformativo;

    //lista de objetos criados na cena
    public List <GameObject> objetosCena = new List<GameObject>();
	bool iniciaApp = false;

	//Geoposicionamento
	float x;
	float z;
	public GeoPosicionamento geo;
	public bool testePOIPC;

	//mudança de cena
	AsyncOperation async;

	//objetos que serão aumetnados por marcadores
	public GerenteMarcadorAumenta imageTargetCloud;

	void Awake () {
        //desabilita o descanso de tela
        Screen.sleepTimeout = SleepTimeout.NeverSleep;

		if (indice == null)
        	indice = GameObject.Find ("Indices").GetComponent<Indices> ();

		if (imageTargetCloud == null)
			imageTargetCloud = GameObject.Find ("ImageTargetCloud").GetComponent<GerenteMarcadorAumenta> ();
		
        testePOIPC = indice.testePOIPC;

		if (testePOIPC) {
			geo.latidudeAtual = -20.18751f;
			geo.longitudeAtual = -40.25404f;
			geo.latidudeInicial= -20.18751f;
			geo.longitudeInicial = -40.25404f;
		    x = -20.18757f;//latidute
			z = -40.25402f;//longetude
			camera.GetComponent<cameraMove> ().testePOIPC = testePOIPC;
			testePOIPC = false;
		}

		//enquanto não se tem o 1o valor coletado d gps, tem que ficar insistindo
        //extremamente necessário pois senão ele carrega tuuuuudddooo errado
		if (geo.primeiraVez == false) {
			x = geo.latidudeInicial;
			z = geo.longitudeInicial;
        }
	}

	void Start () {}

    void Update() {
        obsFeedback.text = "x=" + camera.transform.position.x + ", Z=" + camera.transform.position.z;

        //para sair do app
        if (Input.GetKeyDown(KeyCode.Escape)){
            Application.Quit();
        }
		//preciso garantir que os objetos criados somente o serão se os dados do GPS estão sendo lidos
		if (geo.latidudeAtual != 0 && geo.longitudeAtual != 0 && camera.GetComponent<cameraMove>().calibra == false && 
			iniciaApp == false){

			/*teste do norte verdadeiro que não rolou

			//os objetos serão positicionados conforme estiver a rotação da camera do personagem
			//nesse caso o trueHeading ´=e o norte verdadeiros coletado da bússola
			if(testePOIPC == false){//mas não testa isso quando estiver no computador...
			//	camera.transform.rotation = Quaternion.Euler(0, -Input.compass.trueHeading, 0);
			}
			*/
			x = geo.latidudeInicial;
			z = geo.longitudeInicial;
			iniciaApp = true;
			oqueEssaCenaIraFazer();
		}	
	}

	public void oqueEssaCenaIraFazer(){

		//controleAppQualificadorEndereco ();
		testeArtigo();
	}

    public void testeArtigo(){

        criaObjetosCena();

    }

    public void criaObjetosCena (){

		//cria os objetos
		for (int i = 0; i < indice.projeto.objetosMultimidia.Count; i++) {
			//GameObject objetoA3RA = Instantiate(Resources.Load("ObjetoA3RA"), new Vector3(0, 0, 0), Quaternion.identity) as GameObject;
			GameObject objetoA3RA = Instantiate(Resources.Load("ObjetoA3RA"), new Vector3(0, 0, 0), this.transform.rotation) as GameObject;
			objetoA3RA.GetComponent<ObjetoA3RA>().objetoMultimidia = indice.projeto.objetosMultimidia[i];

            //objetos com geo-posicionamento
			if (indice.projeto.objetosMultimidia [i].idGeo != "null") {
				//longitude  é -x, o menos está dentro do posicionamento
				//latitude é z
				//altura é y
				float posZ = float.Parse (indice.projeto.objetosMultimidia [i].GPS [0].latitude);
				float posX = float.Parse (indice.projeto.objetosMultimidia [i].GPS [0].longitude);
				float posY = 0;
				//latitude inicial é meu x=0 e z=0, pego a diferença entre minha posição inicial e a nova posição
				//multiplico por uma variavel empirica
				float posAtualX = -convertePos (posX, geo.longitudeInicial); 
				float posAtualZ = -convertePos (posZ, geo.latidudeInicial);   
                
                objetoA3RA.transform.localPosition = new Vector3 (posAtualX, posY, posAtualZ);

                string t = "depois da criação: " + indice.projeto.objetosMultimidia[i].nomeObjeto + " lat=" +
                    posAtualZ + " lon=" + posAtualX + ".";
                this.insereTextoDebug(t);

				objetoA3RA.GetComponent<ObjetoA3RA>().souPOI = true;
				//aparece o mapmaker
                if (indice.projeto.objetosMultimidia [i].GPS [0].tipo == "mapMarker"){
                    objetoA3RA.GetComponent<ObjetoA3RA> ().objetosRAPossiveis[0]
						.GetComponent<POI> ().atualizaNome (indice.projeto.objetosMultimidia [i].GPS [0].gpsNome);
					objetoA3RA.GetComponent<ObjetoA3RA> ().objetosRAPossiveis[0]
						.GetComponent<POI> ().atualizaLatitude (indice.projeto.objetosMultimidia [i].GPS [0].latitude);
					objetoA3RA.GetComponent<ObjetoA3RA> ().objetosRAPossiveis[0]
						.GetComponent<POI> ().atualizaLongitude (indice.projeto.objetosMultimidia [i].GPS [0].longitude);
                }
				//o objetivo é que não seja exibido nada e que a janela de informativo do gerente seja acionada
                if (indice.projeto.objetosMultimidia[i].GPS[0].tipo == "informativo"){
					//nenhuma ação no gerente é necessária, tem que partir do objeto
                }

                if (indice.projeto.objetosMultimidia[i].GPS[0].tipo == "Modelo3D"){
					
                    //marretada para teste que deve ser corrigido

                    objetoA3RA.GetComponent<ObjetoA3RA>().objetosRA = objetoA3RA.GetComponent<ObjetoA3RA>().objetosRAPossiveis[1]; 
                    objetoA3RA.GetComponent<ObjetoA3RA>().objetosRAPossiveis[1].SetActive(true);//objeto 3d
                }
               
				objetoA3RA.name = indice.projeto.objetosMultimidia [i].nomeObjeto;
                objetoA3RA.GetComponent<ObjetoA3RA>().textoExibi = indice.projeto.objetosMultimidia[i].textoObjeto;

               objetosCena.Add (objetoA3RA);
			} 

			//objetos com arquivos
			if (indice.projeto.objetosMultimidia[i].idArquivo != "null") {}



			//objetos com multimídia
            if (indice.projeto.objetosMultimidia [i].idMarcador != "null") {
				
				objetoA3RA.name = indice.projeto.objetosMultimidia [i].nomeObjeto;
				objetoA3RA.GetComponent<ObjetoA3RA>().objetoMultimidia = indice.projeto.objetosMultimidia [i];
				objetoA3RA.GetComponent<ObjetoA3RA>().souMarcador = true;
				this.GetComponent<GerenteCloudReco> ().objetosA3RA.Add (objetoA3RA);

				if (indice.projeto.objetosMultimidia [i].idArquivo != "null") {
					//aqui segue a configuração se tiver elemento 3d a ser aumentado



				} else {
					//estou entendendo que se tem marcador sem elemento 3d a ser aumentado então ele vai exibir texto
					GameObject objetoA3RATexto = Instantiate(Resources.Load("ObjetoA3RA"), new Vector3(0, -50, 0), 
						Quaternion.identity) as GameObject;
					objetoA3RATexto.GetComponent<ObjetoA3RA> ().objetoMultimidia.textoObjeto = 
						objetoA3RA.GetComponent<ObjetoA3RA> ().objetoMultimidia.textoObjeto;
					objetoA3RATexto.GetComponent<ObjetoA3RA> ().souInformativo = true;
					objetoA3RATexto.GetComponent<ObjetoA3RA> ().souFilhoDeMarcador = true;
					objetoA3RATexto.name = "ObjetoTextoDoMarcador-" + objetoA3RA.name;
					Evento e = new Evento ();
					e.objeto = objetoA3RATexto;
					e.acao = "1";
					e.gatilho = objetoA3RA;
					objetoA3RATexto.GetComponent<ObjetoA3RA> ().eventos.Add (e);
					ObjetoMarcadorAumentado objMarcAumentado = new ObjetoMarcadorAumentado();
					objMarcAumentado.objetoAumentado = objetoA3RATexto;
					objMarcAumentado.targetID = indice.projeto.objetosMultimidia [i].marcador [0].targetID;
					imageTargetCloud.objetosAumentado.Add (objMarcAumentado);
				}
				objetosCena.Add (objetoA3RA);
			} 

			//objetos de texto
			if (indice.projeto.objetosMultimidia [i].idMarcador == "null" &&
				indice.projeto.objetosMultimidia[i].idArquivo == "null" &&
				indice.projeto.objetosMultimidia [i].idGeo == "null") {
					
				objetoA3RA.GetComponent<ObjetoA3RA>().objetosRA = Instantiate(Resources.Load("objVazio"), 
												new Vector3(0, 0, 0), Quaternion.identity) as GameObject;
				objetoA3RA.GetComponent<ObjetoA3RA>().souInformativo = true;
				objetoA3RA.name = indice.projeto.objetosMultimidia [i].nomeObjeto;
				objetosCena.Add (objetoA3RA);
			} 

		}

		//depois que criar todos os objetos, todos ficarão invisiveis
		for (int i = 0; i < objetosCena.Count; i++) {
			objetosCena[i].GetComponent<ObjetoA3RA>().objetosRA.SetActive(false);
		}

		//rodando os eventos para cada
		if(indice.projeto.objetosEventos.Count > 0){
			/*
			configura os eventos dos objetos criados
			1	Habilitação de objeto	
			2	Habilitação de objeto por colisão	
			3	Aumenta objeto	
			4	Modificação de índices
			5	Habilitação por tempo
			6	Habilitação de outros
			7	Habilitação de Feedback
			*/

			for (int i = 0; i < indice.projeto.objetosEventos.Count; i++) {
				//se a ação é Habilitação de objeto
				if(indice.projeto.objetosEventos[i].idAcoes == "1"){
					//se o objeto que habilita é o inicia programa o objeto é = a 1
					if (indice.projeto.objetosEventos [i].idObjeto == "1") {
						GameObject temp = this.getObjetoCena (indice.projeto.objetosEventos [i].gatilho);
						Evento e = new Evento ();
						e.objeto = Instantiate (Resources.Load ("Inicio Programa"), 
							new Vector3 (0, -50, 0), Quaternion.identity) as GameObject;
						e.objeto.name = "Inicio Programa";
						e.objeto.GetComponent<ObjetoA3RA> ().objetosRAPossiveis[0].SetActive (false);
						e.objeto.GetComponent<ObjetoA3RA> ().objetosRAPossiveis[1].SetActive (false);
						e.acao = indice.projeto.objetosEventos[i].idAcoes;
						e.gatilho = temp;
						temp.GetComponent<ObjetoA3RA> ().objetosRA.SetActive (true);
						temp.GetComponent<ObjetoA3RA> ().fuiAcionado = true;
						e.objeto.GetComponent<ObjetoA3RA> ().eventos.Add (e);
					} else {
						//se o objeto que habilita tem como gatilho o final do programa que é o objeto = 2
						if (indice.projeto.objetosEventos [i].gatilho == "2") {
							GameObject temp = this.getObjetoCena (indice.projeto.objetosEventos [i].idObjeto);
							Evento e = new Evento ();
							e.objeto = temp;
							e.acao = indice.projeto.objetosEventos[i].idAcoes;
							e.gatilho = Instantiate (Resources.Load ("Fim de Programa"), 
								new Vector3 (0, -50, 0), Quaternion.identity) as GameObject;
							e.gatilho.name = "Fim de Programa";
							e.gatilho.GetComponent<ObjetoA3RA> ().objetosRAPossiveis[0].SetActive (false);
							e.gatilho.GetComponent<ObjetoA3RA> ().objetosRAPossiveis[1].SetActive (false);
							e.objeto.GetComponent<ObjetoA3RA> ().eventos.Add (e);
						} else {
							GameObject temp = this.getObjetoCena (indice.projeto.objetosEventos [i].idObjeto);
							Evento e = new Evento ();
							e.objeto = temp;
							e.acao = indice.projeto.objetosEventos[i].idAcoes;
							e.gatilho = this.getObjetoCena (indice.projeto.objetosEventos [i].gatilho);
							temp.GetComponent<ObjetoA3RA> ().eventos.Add (e);
						}
					}
				}

				//2	Habilitação de objeto por colisão	
				if(indice.projeto.objetosEventos[i].idAcoes == "2"){
					if (indice.projeto.objetosEventos [i].gatilho == "2") {
						Evento e = new Evento ();
						e.objeto = this.getObjetoCena (indice.projeto.objetosEventos [i].idObjeto);
						e.acao = indice.projeto.objetosEventos[i].idAcoes;
						e.gatilho = Instantiate (Resources.Load ("Fim de Programa"), 
							new Vector3 (0, -50, 0), Quaternion.identity) as GameObject;
						e.gatilho.name = "Fim de Programa";
						e.objeto.GetComponent<ObjetoA3RA> ().souColisao = true;
						e.objeto.GetComponent<ObjetoA3RA> ().eventos.Add (e);
					} else {
						GameObject temp = this.getObjetoCena (indice.projeto.objetosEventos [i].idObjeto);
						Evento e = new Evento ();
						e.objeto = temp;
						e.acao = indice.projeto.objetosEventos[i].idAcoes;
						e.gatilho = this.getObjetoCena (indice.projeto.objetosEventos [i].gatilho);
						temp.GetComponent<ObjetoA3RA> ().eventos.Add (e);
						temp.GetComponent<ObjetoA3RA> ().souColisao = true;
					}
				}

				//3	Aumenta objeto	
				if(indice.projeto.objetosEventos[i].idAcoes == "3"){

				}

				//4	Modificação de índices
				if(indice.projeto.objetosEventos[i].idAcoes == "4"){

				}

				//5	Habilitação por tempo
				if(indice.projeto.objetosEventos[i].idAcoes == "5"){

				}

				//6	Habilitação de outros
				if(indice.projeto.objetosEventos[i].idAcoes == "6"){

				}

				//7	Habilitação de Feedback
				if(indice.projeto.objetosEventos[i].idAcoes == "7"){

				}

			}

		}else{
			//se não houver eventos significa que tods os mobjetos aparecerão na cena sem nenhum controle

			for (int i = 0; i < objetosCena.Count; i++) {
				objetosCena[i].SetActive(true);
			}

		}
	}

	GameObject getObjetoCena (string id){
		GameObject g = null;
		for (int i = 0; i < objetosCena.Count; i++) {
			if(objetosCena[i].GetComponent<ObjetoA3RA>().objetoMultimidia.idObjeto == id){
				g = objetosCena[i];
			}
		}
		return g;
	}


	//conversão de posição gps para posição no mundo virtual 
	public float convertePos(float posFinal, float posInicial){
		return (-(posInicial-posFinal)*10000f)*14.7f;
	}
		/*
	public void criaPOI(float posX,float posY,float posZ, string nome){
		//longitude  é -x, o menos está dentro do posicionamento
		//latitude é z
		//altura é y

		//latitude inicial é meu x=0 e z=0, pego a diferença entre minha posição inicial e a nova posição
		//multiplico por uma variavel empirica
		float posAtualX = -convertePos(posX, geo.longitudeInicial);
		float posAtualZ = -convertePos(posZ, geo.latidudeInicial);

		GameObject pos = Instantiate(Resources.Load("POI"), new Vector3(posAtualX,posY,posAtualZ), Quaternion.identity) as GameObject;
		pos.GetComponent<POI> ().atualizaNome (nome);
		pos.name = "POI." + nome;

		objetosCena.Add (pos);

		string t ="" + nome + "Alt=" + posY+", "+ "Lat=" + posAtualX+", " + "Long" + posAtualZ+", ";

		this.insereTextoDebug (t);
	}
    */
	public void limpaObjetosCena(){
		for (int i = 0; i < objetosCena.Count; i++) {
			Destroy (objetosCena [i]);
		}
		objetosCena.Clear();
	}

	public void recarregaObjetosCena(){
		limpaObjetosCena ();

	}


	//chamada para mudança de cena
	public void chamaRealidadeAumentada(){
		async = SceneManager.LoadSceneAsync ("Realidade Aumentada" );
	}

	public void chamaVirtualidadeAumentada(){
		foreach (GameObject o in Object.FindObjectsOfType<GameObject>()) {
			Destroy(o);
		}
		async = SceneManager.LoadSceneAsync ("Virtualidade Aumentada" );
	}

	public void chamaMenuPrincipal(){
		Destroy(GameObject.Find ("Indices"));
		foreach (GameObject o in Object.FindObjectsOfType<GameObject>()) {
			//destroi tudo menos o indice...
			//if (o.name != "Indices")
				Destroy(o);
		}
		indice.qualCenaChamar = "MenuPrincipal";
		async = SceneManager.LoadSceneAsync ("Loading");
	}
		
	public void insereTextoDebug(string t){
		textoDebug.text +="\n"+t;

		textoDebug.rectTransform.sizeDelta = new Vector2(textoDebug.rectTransform.rect.width, 
			textoDebug.rectTransform.rect.height+24);
	}

    

	//UI
	public void saiPainelMensagem(){
		painelMensagem.SetBool ("sai", true);
		painelMensagem.SetBool ("entra", false);
	}

	public void EntraPainelMensagem(){
		painelMensagem.SetBool ("sai", false);
		painelMensagem.SetBool ("entra", true);
	}

	public void insereTextoUIMensagem(string t){
		mensagem.text =t;
	}

	public void acionaInformaObjTexto (GameObject g, string texto){
		quemManipulouPainelInformativo = g;
		informativo.text = texto;
		painelInformativo.SetActive(true);
	}
	//informa ao objeto texto que a mensagem exibida ao usuário foi fechada ele pode acionar o seu gatilho
	public void informaObjTexto (){
	//	Debug.Log ("Estou infmando para " + quemManipulouPainelInformativo.name + " que ele deve acionar o gatilho dele");
		quemManipulouPainelInformativo.GetComponent<ObjetoA3RA>().acionaGatilho();
		quemManipulouPainelInformativo = null;
	}

    //aqui vamos controlar o quando o usuário colide com a posição. Se for para encontrar, ele avisa que está sobre a posição
    // se for informativo, ele exibe a informação
	public void controlaPainelColisao(bool b, GameObject g){
		painelColisao.SetActive(b);
		//textoDaPosColisao.text = "Você está sobre "+g.GetComponent<ObjetoA3RA>().objetoMultimidia.nomeObjeto;
	}



}
