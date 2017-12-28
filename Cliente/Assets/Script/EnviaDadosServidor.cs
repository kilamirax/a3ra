using UnityEngine;
using System.Collections;
using UnityEngine.UI;
using System.Text;
using System.Collections.Generic;

public class EnviaDadosServidor : MonoBehaviour {

	//ui do cadastro de geoposição
	public Text latidude;
	public Text longitude;
	public Text altidute;
	public InputField nomeGPS;
	public InputField obsGPS;

	//ui do cadastro de feedback
	public InputField obsFeed;
	public GameObject painelFeed;

	public string gpsJson ="";

	Indices indice;

	void Start () {
		if (GameObject.Find ("Indices")) {
			indice = GameObject.Find ("Indices").GetComponent<Indices> ();
		}
	}

	void Update () {}

	public void atualizaCampoPos(){
		if (this.GetComponent<Gerente> ().geo.offline) {
			latidude.text = "0";
			longitude.text = "0";
			altidute.text = "0";
		} 

		/*else {
			latidude.text = "" + this.GetComponent<Gerente> ().geo.latidudeAtual;
			longitude.text = "" + this.GetComponent<Gerente> ().geo.longitudeAtual;
			altidute.text = "" + this.GetComponent<Gerente> ().geo.altiduteAtual;
		}*/
	}

	//cadastro de geoposição pelo celular
	public void addCampoGPS(){
		gpsJson ="";

		//o texto do campo da UI longitude e latitude está sendo atualizado sempre pelo gerente GeoPosicionamento
		gpsJson = "{\"latitude\":\""+ this.GetComponent<Gerente> ().geo.latidudeAtual+"\"," +
			"\"longitude\":\""+ this.GetComponent<Gerente> ().geo.longitudeAtual+"\"," +
			"\"altura\":\"0.00000\"," +
			"\"nome\":\""+indice.usuarioLogado.nome+" "+Random.Range(0,50)+" feedback gps = " + nomeGPS.text+"\","+
			"\"texto\":\"feedback gps = " + obsGPS.text +"\","+
			"\"tipoGPS\":\"Feedback\"," +
			"\"USUARIOS_idUSUARIOS\":\""+indice.usuarioLogado.idUSUARIOS+"\"}";
		
		Debug.Log(gpsJson);
		atualizaBancoGPS (gpsJson);
	}

	void atualizaBancoGPS(string json){
		StartCoroutine(enviaGPS(json));
	}

	IEnumerator enviaGPS(string json) {
		WWWForm form = new WWWForm();
		Dictionary<string, string> headers =  new Dictionary<string, string>();
		headers.Add("Content-Type", "application/json");
		byte[] body = Encoding.UTF8.GetBytes(json);
		WWW www = new WWW(indice.url+"gps/"+indice.projeto.idPROJETOS, body, headers);

		yield return www;
		Debug.Log(www.text);
		//this.GetComponent<Gerente> ().insereTextoUIMensagem(www.text);
		this.GetComponent<Gerente> ().insereTextoUIMensagem("GPS Cadastrado!");
		this.GetComponent<Gerente> ().EntraPainelMensagem ();
	}

	//cadastro de feedback pelo usuário
	public void addCampoFeedback(){
		painelFeed.SetActive (false);
		gpsJson ="";
		gpsJson = "{\"latitude\":\""+ this.GetComponent<Gerente> ().geo.latidudeAtual+"\"," +
			"\"longitude\":\""+ this.GetComponent<Gerente> ().geo.longitudeAtual+"\"," +
			"\"altura\":\"0.00000\"," +
			"\"nome\":\""+indice.usuarioLogado.nome+" "+Random.Range(0,50)+" feedback\","+
			"\"texto\":\"feedback = " +indice.usuarioLogado.nome+"\","+
			"\"tipoGPS\":\"Feedback\"," +
			"\"USUARIOS_idUSUARIOS\":\""+indice.usuarioLogado.idUSUARIOS+"\","
			+
			"\"tipoFeed\":\"usuario\"," +
			"\"texto_feedback\":\"" + obsFeed.text +"\"}";

		Debug.Log(gpsJson);
		atualizaBancoFeedback (gpsJson);
	}

	void atualizaBancoFeedback(string json){
		StartCoroutine(enviaFeedback(json));
	}

	IEnumerator enviaFeedback(string json) {
		WWWForm form = new WWWForm();
		Dictionary<string, string> headers =  new Dictionary<string, string>();
		headers.Add("Content-Type", "application/json");
		byte[] body = Encoding.UTF8.GetBytes(json);
		WWW www = new WWW(indice.url+"feedback/"+indice.projeto.idPROJETOS, body, headers);

		yield return www;
		Debug.Log(www.text);
		//this.GetComponent<Gerente> ().insereTextoUIMensagem(www.text);
		this.GetComponent<Gerente> ().insereTextoUIMensagem("Respondido!");
		this.GetComponent<Gerente> ().EntraPainelMensagem ();
	}

}
