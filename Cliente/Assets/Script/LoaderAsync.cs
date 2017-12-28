using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;
using System.Collections;

public class LoaderAsync : MonoBehaviour {

	public string nomeCena;
	AsyncOperation async;
	public Indices indice;
	public Text textoLoading;

	void Start () {
		if (indice == null) {
			indice = GameObject.Find ("Indices").GetComponent<Indices> ();
			nomeCena = indice.qualCenaChamar;
		} else {
			nomeCena = "sem cena";
		}
			
		StartCoroutine(load());
	}

	IEnumerator load () {
		if (nomeCena == "sem cena") {
			textoLoading.text = "sem cena para carregar...";
			yield break;
		}
	
		async = SceneManager.LoadSceneAsync (nomeCena);

		async.allowSceneActivation = false;
		//Debug.Log ("load pedido");

		while (!async.isDone) {
			//Debug.Log (async.progress+"%");
			textoLoading.text = "Carregando... ";
			if (async.progress >= 0.9f) {
				async.allowSceneActivation = true;
				//em teoria tá pronto
				break;
			}
			yield return null;
		}

	}
		
}
