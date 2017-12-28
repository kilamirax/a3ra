using System.Collections;
using System.Collections.Generic;
using UnityEngine;


public class GerenteMarcadorAumenta : MonoBehaviour {

	public List <ObjetoMarcadorAumentado> objetosAumentado = new List<ObjetoMarcadorAumentado>();

	void Start () {}
	void Update () {}

	void habilitaObjeto(GameObject g){
		for (int i = 0; i < objetosAumentado.Count; i++) {
			if(objetosAumentado[i].objetoAumentado == g){
				objetosAumentado[i].objetoAumentado.SetActive(true);
			}
		}
	}
	void desabilitaObjetos(GameObject g){
		for (int i = 0; i < objetosAumentado.Count; i++) {
			if(objetosAumentado[i].objetoAumentado != g){
				objetosAumentado[i].objetoAumentado.SetActive(false);
			}
		}
	}
}
