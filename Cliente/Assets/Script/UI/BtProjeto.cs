using UnityEngine;
using System.Collections;
using UnityEngine.SceneManagement;
using UnityEngine.UI;
using System.Collections.Generic;

public class BtProjeto : MonoBehaviour {

	public ObjetoProjeto projeto;
	public GameObject gerente;

	// Use this for initialization
	void Start () {	
		gerente = GameObject.Find ("Gerente");
		this.gameObject.GetComponent<Button>().onClick.AddListener(() => {
			gerente.GetComponent<UIMenuPrincipal>().selecionaProjeto(this.gameObject);
		});
	}
}
