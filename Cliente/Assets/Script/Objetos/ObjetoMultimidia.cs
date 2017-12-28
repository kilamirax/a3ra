using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using System.Xml.Serialization;
using System;

[Serializable]
public class ObjetoMultimidia : System.Object {

	public string idObjeto = "";
	public string nomeObjeto = "";
	public string textoObjeto = "";
	public string targetIDObjeto = "";
	public string idMarcador = "";
	public string idGeo = "";
	public string idArquivo = "";

	public List <ObjetoGPS> GPS = new List<ObjetoGPS>();
	public List <ObjetoMarcador> marcador = new List<ObjetoMarcador>();
	public List <ObjetoArquivo> arquivo = new List<ObjetoArquivo>();

	public List <ObjetoEvento> evento = new List<ObjetoEvento>();
}
