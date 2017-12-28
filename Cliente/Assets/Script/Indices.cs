using UnityEngine;
using System.Collections;

public class Indices : MonoBehaviour {

	public string qualCenaChamar="";
	public ObjetoProjeto projeto = new ObjetoProjeto();//projeto escolhido
	public ObjetoUsuario usuarioLogado;
	//public string url = "http://localhost/GoDaddy/A3RA/"; //localhost
	//public string url = "http://a3ra.esy.es/A3RA/";		//Hostinger
	//public string url = "http://jameswarlock.com.br/A3RA/";//GoDaddy
	//public string url = "http://ec2-52-67-226-97.sa-east-1.compute.amazonaws.com/A3RA/";//Terraria
	public string url = "http://ec2-52-67-24-163.sa-east-1.compute.amazonaws.com/A3RA/";//valfenda
    public bool testePOIPC = false;

    void Awake() {
		DontDestroyOnLoad (transform.gameObject);
	}
}
