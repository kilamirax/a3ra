using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class POI : MonoBehaviour {

	public TextMesh latitude;
	public TextMesh longitude;
	public TextMesh altitude;
	public TextMesh nomeObjeto;
	public GameObject mapMaker;
	public string nome;

	Gerente gerente;

	//Transform temp;

	void Start () {
		if (GameObject.Find ("Gerente")) {
			gerente = GameObject.Find ("Gerente").GetComponent<Gerente> ();
		}
	}
	void Update () {

		//fazer com que o poi sempre fique de frente com a camera
		transform.LookAt(gerente.camera.transform);
       
		if (Vector3.Distance (this.transform.position, gerente.camera.transform.position) < 20) {
			//Debug.Log ("ok, sai e vou enviar mensatem para o painel");
			nomeObjeto.text = "";
			mapMaker.SetActive (false);
			gerente.controlaPainelColisao (true, this.gameObject);
		} else {
			//Debug.Log ("ok, voltei e vou tirar o painel");
			nomeObjeto.text = nome;
			mapMaker.SetActive (true);
			gerente.controlaPainelColisao (false, this.gameObject);
		}
        
	}


	public void atualizaLatitude(string l){
		latitude.text = "" + l;
	}
	public void atualizaLongitude(string l){
		longitude.text = "" + l;
	}
	public void atualizaAltitude(string a){
		altitude.text = "" + a;
	}
	public void atualizaNome(string n){
		nome = n;
		nomeObjeto.text = n;
	}
}
