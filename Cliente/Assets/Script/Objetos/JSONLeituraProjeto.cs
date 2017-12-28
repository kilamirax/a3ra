using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using UnityEngine.SceneManagement;
using System;

public class JSONLeituraProjeto : MonoBehaviour {

	public GameObject gerente;

	List <ObjetoMultimidia> objetosMultimidia = new List<ObjetoMultimidia>();

	public List <ObjetoProjeto> projetosPublicos = new List<ObjetoProjeto>();
	public List <ObjetoProjeto> projetosPrivados = new List<ObjetoProjeto>();

	string dados = "";
	string mensagemErro = "";

	public bool terminouDeCarregarObjetos = false; //utilizado pelo loader da cena

	//public bool iniciaTestePC = true; //utilizado pelo loader da cena

	Scene scene;
	void Start () {
		if (GameObject.Find ("Gerente")) {
			gerente = GameObject.Find ("Gerente");
		}

		scene = SceneManager.GetActiveScene();


		//testePC ();

	}
	/*
	public void testePC (){
		StartCoroutine(carregaProjetosPublicosId("1"));
		StartCoroutine(carregaObjetosPorProjetos("1"));
	}
*/

	public IEnumerator carregaProjetosPublicos(){
		string urlLeitura = this.GetComponent<Indices>().url+"projetosPublicos";
		//Debug.Log(urlLeitura);
		WWW www = new WWW(urlLeitura);
		yield return www;
		if (!string.IsNullOrEmpty(www.error)){
			Debug.Log("Error : " + www.error);
			mensagemErro = "Erro ao carregar os projetos.";
		}else {
			//Debug.Log(www.text);
			JSONObject j = new JSONObject(www.text);
			trataProjetos (j);
		}
	}

	public IEnumerator carregaProjetosPrivados(string idUser){
		string urlLeitura = this.GetComponent<Indices>().url+"projetosPrivados/"+ idUser;
		//Debug.Log(urlLeitura);
		WWW www = new WWW(urlLeitura);
		yield return www;
		if (!string.IsNullOrEmpty(www.error)){
			Debug.Log("Error : " + www.error);
			mensagemErro = "Erro ao carregar os projetos.";
		}else {
			JSONObject j = new JSONObject(www.text);
			trataProjetos (j);
		}
	}

	public void trataProjetos(JSONObject obj){
		//Debug.Log(obj);
		foreach (JSONObject j in obj.list) {
			ObjetoProjeto o = new ObjetoProjeto ();
			for (int i = 0; i < j.Count; i++) {
				string chave = (string)j.keys [i];
				if (chave == "idPROJETOS") {
					o.idPROJETOS = "" + j.GetField (j.keys [i]);
					o.idPROJETOS = o.idPROJETOS.Replace ("\"", "");
				}
				if (chave == "nome") {
					o.nomeProjeto = "" + j.GetField (j.keys [i]);
					o.nomeProjeto = o.nomeProjeto.Replace ("\"", "");
				}
				if (chave == "texto") {
					o.textoProjeto = "" + j.GetField (j.keys [i]);
					o.textoProjeto = o.textoProjeto.Replace ("\"", "");
					//Debug.Log(o.textoProjeto);
				}
				if (chave == "tipo") {
					o.tipoProjeto = "" + j.GetField (j.keys [i]);
					o.tipoProjeto = o.tipoProjeto.Replace ("\"", "");
				}
				if (chave == "USUARIOS_idUSUARIOS") {
					o.usuarioProjeto = "" + j.GetField (j.keys [i]);
					o.usuarioProjeto = o.usuarioProjeto.Replace ("\"", "");
				}
				if (chave == "acesso") {
					o.acessoProjeto = "" + j.GetField (j.keys [i]);
					o.acessoProjeto = o.acessoProjeto.Replace ("\"", "");
				}
			}


			if (o.acessoProjeto == "publico") {
				if (!verificaSeNaoExisteProjeto (o.idPROJETOS, projetosPublicos)) {
                    StartCoroutine(carregaObjetosPorProjetos(o));
                    StartCoroutine(carregaEventos(o.idPROJETOS, o));
					projetosPublicos.Add (o);
				}
			}
			if (o.acessoProjeto == "privado") {
                if (!verificaSeNaoExisteProjeto (o.idPROJETOS, projetosPrivados)) {
                    StartCoroutine(carregaObjetosPorProjetos(o));
                    StartCoroutine(carregaEventos(o.idPROJETOS, o));
                    projetosPrivados.Add (o);
				}
			}

			if (scene.name == "MenuPrincipal") {
				gerente.GetComponent<UIMenuPrincipal> ().criaBtProjeto (o);
			}
			if (scene.name == "Realidade Aumentada") {
				this.GetComponent<Indices> ().projeto = o;
			}
		}
	}

	public bool verificaSeNaoExisteProjeto(string idPROJETOS, List <ObjetoProjeto> p){
		bool verifica = false;
		for (int i = 0; i < p.Count; i++) {
			if (p[i].idPROJETOS == idPROJETOS) {
				verifica = true;
			}
		}
		return verifica;
	}

	public IEnumerator carregaObjetosPorProjetos(ObjetoProjeto projeto)
    {
		string urlLeitura = this.GetComponent<Indices>().url+"objetosPorProjeto/"+ projeto.idPROJETOS;
		//Debug.Log(urlLeitura);
		WWW www = new WWW(urlLeitura);
		yield return www;
		if (!string.IsNullOrEmpty(www.error)){
			Debug.Log("Error : " + www.error);
			mensagemErro = "Erro ao carregar os projetos.";
		}else {
			//Debug.Log(projeto.idPROJETOS+ "   "+ www.text);
			JSONObject j = new JSONObject(www.text);
			ObjetosPorProjeto (j, projeto);
		}
	}

	public void ObjetosPorProjeto(JSONObject obj, ObjetoProjeto projeto)
    {
        //{"idOBJETO":"4","MARCADORES_idMARCADORES":null,"GEOPOS_idGEOPOS":"1","ARQUIVOS_idARQUIVOS":null,"nome":"CasaObj","texto":"casa","usuario":"2"}
        foreach (JSONObject j in obj.list){
			ObjetoMultimidia o = new ObjetoMultimidia();
			for(int i = 0; i < j.Count; i++){
				string chave = (string)j.keys [i];
				//string campo = ""+j.GetField (j.keys [i]);
				//Debug.Log(chave+" = "+campo);
				if (chave == "idOBJETO") {
					o.idObjeto = "" + j.GetField (j.keys [i]);
					o.idObjeto = o.idObjeto.Replace ("\"","");
				}
				if (chave =="MARCADORES_idMARCADORES") {
					o.idMarcador ="" + j.GetField (j.keys [i]);
					o.idMarcador = o.idMarcador.Replace ("\"","");
				}
				if (chave == "GEOPOS_idGEOPOS") {
					o.idGeo = "" + j.GetField (j.keys [i]);
					o.idGeo = o.idGeo.Replace ("\"","");
				}
				if (chave == "ARQUIVOS_idARQUIVOS") {
					o.idArquivo = "" + j.GetField (j.keys [i]);
					o.idArquivo = o.idArquivo.Replace ("\"","");
				}
				if (chave == "nome") {
					o.nomeObjeto = "" + j.GetField (j.keys [i]);
					o.nomeObjeto = o.nomeObjeto.Replace ("\"","");
				}
				if (chave == "texto") {
					o.textoObjeto = "" + j.GetField (j.keys [i]);
					o.textoObjeto = o.textoObjeto.Replace ("\"","");
				}
				if (chave == "TARGETID") {
					o.targetIDObjeto = "" + j.GetField (j.keys [i]);
					o.targetIDObjeto = o.targetIDObjeto.Replace ("\"","");
				}
			}
            projeto.objetosMultimidia.Add (o);
		}

		for (int i = 0; i < projeto.objetosMultimidia.Count; i++) {
			if (projeto.objetosMultimidia[i].idMarcador != null) {
				StartCoroutine (carregaMarcador (projeto.objetosMultimidia[i]));
            }
			if (projeto.objetosMultimidia[i].idGeo != null) {
				StartCoroutine (carregaGPS (projeto.objetosMultimidia[i]));
			}
			if (projeto.objetosMultimidia[i].idArquivo != null) {
				StartCoroutine (carregaArquivo (projeto.objetosMultimidia[i]));
			}
        }

        terminouDeCarregarObjetos = true;
	}

	IEnumerator carregaGPS(ObjetoMultimidia obj){
		string url = this.GetComponent<Indices>().url+"gps/"+ obj.idGeo;
		WWW www = new WWW(url);
		yield return www;
		dados = www.text;
		JSONObject j = new JSONObject(dados);
		carregarListaObjetosGPSNoProjeto(j, obj);
	}

	public void carregarListaObjetosGPSNoProjeto(JSONObject j, ObjetoMultimidia obj)
    {
		//﻿﻿{"idGEOPOS":"8","latitude":"-20.18752","longitude":"-40.25404","altura":"0.00000","nome":"t feedback gps = 1","texto":"feedback gps = x=0, Z=0","USUARIOS_idUSUARIOS":"1"}
		//Debug.Log(j);
		ObjetoGPS o = new ObjetoGPS();
		for(int i = 0; i < j.Count; i++){
			string chave = (string)j.keys [i];
			//string campo = ""+j.GetField (j.keys [i]);
			//Debug.Log(chave+" = "+campo);
			if (chave == "idGEOPOS") {
				o.idGPS = "" + j.GetField (j.keys [i]);
				o.idGPS = o.idGPS.Replace ("\"","");
			}
			if (chave =="nome") {
				o.gpsNome ="" + j.GetField (j.keys [i]);
				o.gpsNome = o.gpsNome.Replace ("\"","");
			}
			if (chave == "texto") {
				o.gpsTexto = "" + j.GetField (j.keys [i]);
				o.gpsTexto = o.gpsTexto.Replace ("\"","");
			}
			if (chave == "latitude") {
				o.latitude = "" + j.GetField (j.keys [i]);
				o.latitude = o.latitude.Replace ("\"","");
			}
			if (chave == "longitude") {
				o.longitude = "" + j.GetField (j.keys [i]);
				o.longitude = o.longitude.Replace ("\"","");
			}
			if (chave == "altura") {
				o.altura = "" + j.GetField (j.keys [i]);
				o.altura = o.altura.Replace ("\"","");
			}
			if (chave == "tipo") {
				o.tipo = "" + j.GetField (j.keys [i]);
				o.tipo = o.tipo.Replace ("\"","");
			}
		}
        obj.GPS.Add(o);
	}
		
	IEnumerator carregaMarcador(ObjetoMultimidia obj){
		string url = this.GetComponent<Indices>().url+"marcador/"+obj.idMarcador;
		WWW www = new WWW(url);
		yield return www;
		dados = www.text;
		JSONObject j = new JSONObject(dados);
		carregarListaObjetosMarcadorNoProjeto(j, obj);
	}

	public void carregarListaObjetosMarcadorNoProjeto(JSONObject j, ObjetoMultimidia obj)
    {
		//﻿﻿{"idMARCADORES":"8","USUARIOS_idUSUARIOS":"1","nome":"o-rei-le--o-600x360.jpg","targetID":"ccbd60289b614785a259b7e1676b13ab","dimensao":"320","tamanho":"50272"}
		ObjetoMarcador o = new ObjetoMarcador();
		for(int i = 0; i < j.Count; i++){
			string chave = (string)j.keys [i];
			//string campo = ""+j.GetField (j.keys [i]);
			//Debug.Log(chave+" = "+campo);
			if (chave == "idMARCADORES") {
				o.idMARCADORES = "" + j.GetField (j.keys [i]);
				o.idMARCADORES = o.idMARCADORES.Replace ("\"","");
			}
			if (chave =="nome") {
				o.nome ="" + j.GetField (j.keys [i]);
				o.nome = o.nome.Replace ("\"","");
			}
			if (chave =="USUARIOS_idUSUARIOS") {
				o.USUARIOS_idUSUARIOS ="" + j.GetField (j.keys [i]);
				o.USUARIOS_idUSUARIOS = o.USUARIOS_idUSUARIOS.Replace ("\"","");
			}
			if (chave == "targetID") {
				o.targetID = "" + j.GetField (j.keys [i]);
				o.targetID = o.targetID.Replace ("\"","");
			}
			if (chave == "dimensao") {
				o.dimensao = "" + j.GetField (j.keys [i]);
				o.dimensao = o.dimensao.Replace ("\"","");
			}
			if (chave == "tamanho") {
				o.tamanho = "" + j.GetField (j.keys [i]);
				o.tamanho = o.tamanho.Replace ("\"","");
			}
		}
		obj.marcador.Add(o);
	}

	IEnumerator carregaArquivo(ObjetoMultimidia obj)
    {
		string url = this.GetComponent<Indices>().url+"arquivo/"+obj.idArquivo;
		WWW www = new WWW(url);
		yield return www;
		dados = www.text;
		JSONObject j = new JSONObject(dados);
		carregarListaObjetosArquivoNoProjeto(j, obj);
	}

	public void carregarListaObjetosArquivoNoProjeto(JSONObject j, ObjetoMultimidia obj)
    {
		//{"idARQUIVOS":"2","nome":"Igreja+do+Milagre+de+Santarem.skp","endereco":"multimidia\/","extensao":"skp","data":"Sat, 04 Feb 17 12:09:39 +0000","USUARIOS_idUSUARIOS":"1","tamanho":"16309553"}
		ObjetoArquivo o = new ObjetoArquivo();
		for(int i = 0; i < j.Count; i++){
			string chave = (string)j.keys [i];
			if (chave == "idARQUIVOS") {
				o.idARQUIVOS = "" + j.GetField (j.keys [i]);
				o.idARQUIVOS = o.idARQUIVOS.Replace ("\"","");
			}
			if (chave =="nome") {
				o.nome ="" + j.GetField (j.keys [i]);
				o.nome = o.nome.Replace ("\"","");
			}
			if (chave == "endereco") {
				o.endereco = "" + j.GetField (j.keys [i]);
				o.endereco = o.endereco.Replace ("\"","");
			}
			if (chave == "extensao") {
				o.extensao = "" + j.GetField (j.keys [i]);
				o.extensao = o.extensao.Replace ("\"","");
			}
			if (chave == "data") {
				o.data = "" + j.GetField (j.keys [i]);
				o.data = o.data.Replace ("\"","");
			}
			if (chave == "altura") {
				o.USUARIOS_idUSUARIOS = "" + j.GetField (j.keys [i]);
				o.USUARIOS_idUSUARIOS = o.USUARIOS_idUSUARIOS.Replace ("\"","");
			}
			if (chave == "tamanho") {
				o.tamanho = "" + j.GetField (j.keys [i]);
				o.tamanho = o.tamanho.Replace ("\"","");
			}
		}
		obj.arquivo.Add(o);
	}

	public IEnumerator carregaEventos(string id, ObjetoProjeto p){
		string url = this.GetComponent<Indices>().url+"eventosPorProjeto/"+id;
		WWW www = new WWW(url);
		yield return www;
		dados =(string) www.text;
		JSONObject j = new JSONObject(dados);
		carregarListaEventosNoProjeto(j,p);
	}

	public void carregarListaEventosNoProjeto(JSONObject obj, ObjetoProjeto projeto){
		/*
		[{"idEVENTOS":"9","OBJETO_idOBJETO":"1","ACOES_idACOES":"1","PROJETOS_idPROJETOS":"8","gatilho":"5"},
		{"idEVENTOS":"10","OBJETO_idOBJETO":"5","ACOES_idACOES":"2","PROJETOS_idPROJETOS":"8","gatilho":"4"},
		{"idEVENTOS":"11","OBJETO_idOBJETO":"4","ACOES_idACOES":"2","PROJETOS_idPROJETOS":"8","gatilho":"6"},
		{"idEVENTOS":"12","OBJETO_idOBJETO":"6","ACOES_idACOES":"2","PROJETOS_idPROJETOS":"8","gatilho":"8"},
		{"idEVENTOS":"13","OBJETO_idOBJETO":"8","ACOES_idACOES":"1","PROJETOS_idPROJETOS":"8","gatilho":"2"}]
		*/
		//Debug.Log(obj.list);

		/*
		'1', 'Habilitação de objeto', 'objeto', 'Faz o objeto ser apresentado a cena.'
		'2', 'Habilitação de objeto por colisão', 'colisão', 'Quando o usuário colidir na geo-posição ou por processamento de imagem um marcador for detectado, \r\n						um objeto será apresentado a cena.'
		'3', 'Aumenta objeto', 'aumenta', 'Quando um objeto é aumentado na realizade. Normalmente quando se cadastra um marcador para realidade aumentada\r\n		                se deseja que um objeto em questão apareça quando o marcador for detectado, e é esse o caso.'
		'4', 'Modificação de índices', 'indices', 'São planejados para modificação de pontuação, vidas ou mesmo fazer com que o usuário perca itens \r\n						já encontrados. A seleção deste tipo de ação habilitará informações a serem preenchidas para complemento das características da ação, \r\n						como por exemplo se será aumentado pontos, deverá ser preenchido a quantidade ou se for para perder itens já coletados que seja \r\n						escolhido qual seera perdido.'
		'5', 'Habilitação por tempo', 'tempo', 'Nesse caso ao ser criado ou aparecer na cena o objeto começará a contar tempo. A ação deve ter o valor \r\n						desse tempo que o objeto irá contar. Ao termino dessa contagem o sistema cliente realizará uma determinada ação, que é outro evento.'
		'6', 'Habilitação de outros eventos', 'eventos', 'Ações podem estar desabilitados e somente com o acionamento desta ação em questão um ou mais \r\n						eventos podem se tornar visíveis. Um exemplo deste tipo de ação é o de fim de aplicação, ou ligação entre outras sequencias de ações.'
		'7', 'Habilitação de Feedback', 'feedback', 'Essa ação é especifica para chamar a função de feedback para o usuário poder contribuir com o projeto'
		*/

		foreach (JSONObject j in obj.list) {
			ObjetoEvento e = new ObjetoEvento();
			for(int i = 0; i < j.Count; i++){
				string chave = (string) j.keys [i];
				if (chave == "idEVENTOS") {
					e.idEventos = "" + j.GetField (j.keys [i]);
					e.idEventos = e.idEventos.Replace ("\"","");
				}
				if (chave =="OBJETO_idOBJETO") {
					e.idObjeto ="" + j.GetField (j.keys [i]);
					e.idObjeto = e.idObjeto.Replace ("\"","");
				}
				if (chave == "ACOES_idACOES") {
					e.idAcoes = "" + j.GetField (j.keys [i]);
					e.idAcoes = e.idAcoes.Replace ("\"","");
				}
				if (chave == "gatilho") {
					e.gatilho = "" + j.GetField (j.keys [i]);
					e.gatilho = e.gatilho.Replace ("\"","");
				}
				if (chave == "gatilho") {
					e.gatilho = "" + j.GetField (j.keys [i]);
					e.gatilho = e.gatilho.Replace ("\"","");
				}
				if (chave == "PROJETOS_idPROJETOS") {
					e.idProjeto = "" + j.GetField (j.keys [i]);
					e.idProjeto = e.idProjeto.Replace ("\"","");
				}

			}
			projeto.objetosEventos.Add(e);
		}
	}


}