using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.Xml.Serialization;
using System;

[Serializable]
public class Evento : System.Object {

	public ObjetoEvento objetosEventos = new ObjetoEvento();
	public GameObject objeto;
	public string acao;
	public GameObject gatilho;
	void Start () {}
	
	// Update is called once per frame
	void Update () {}
}
