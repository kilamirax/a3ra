using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.Xml.Serialization;
using System;

[Serializable]
public class ObjetoProjeto : System.Object {
	public string idPROJETOS = "";
	public string nomeProjeto = "";
	public string textoProjeto = "";
	public string tipoProjeto = "";
	public string usuarioProjeto = "";
	public string acessoProjeto = "";

	public List <ObjetoMultimidia> objetosMultimidia = new List<ObjetoMultimidia>();
	public List <ObjetoEvento> objetosEventos = new List<ObjetoEvento>();
}
