using UnityEngine;
using System.Collections;
using Vuforia;
using System.Collections.Generic;

public class GerenteCloudReco : MonoBehaviour, ICloudRecoEventHandler{

	private CloudRecoBehaviour mCloudRecoBehaviour;
	private ObjectTracker mObjectTracker;
	private ImageTargetBehaviour imageTargetBehaviour;
	public ImageTargetBehaviour imageTargetTemplate;
	private GerenteMarcadorAumenta marcAumenta;

	public List <GameObject> objetosA3RA = new List<GameObject>();

	void Start(){
		CloudRecoBehaviour cloudRecoBehaviour = GetComponent<CloudRecoBehaviour>();
		if (cloudRecoBehaviour)	{
			cloudRecoBehaviour.RegisterEventHandler(this);
		}

		mCloudRecoBehaviour = cloudRecoBehaviour;
		marcAumenta = imageTargetTemplate.GetComponent<GerenteMarcadorAumenta>();
	}

	public void OnInitialized(){
		mObjectTracker = TrackerManager.Instance.GetTracker<ObjectTracker>();
	}

	public void OnInitError(TargetFinder.InitState initError){}
	public void OnUpdateError(TargetFinder.UpdateState updateError){}
	public void OnStateChanged(bool scanning){}

	public void OnNewSearchResult(TargetFinder.TargetSearchResult targetSearchResult){

		if (targetSearchResult.MetaData == null) {
			Debug.Log ("Target metadata not available.");
			return;
		}

		// duplicate the referenced image target
		GameObject newImageTarget = Instantiate(imageTargetTemplate.gameObject) as GameObject;

		imageTargetBehaviour = 
			(ImageTargetBehaviour)mObjectTracker.TargetFinder.EnableTracking(targetSearchResult, newImageTarget);
		/*
		switch(targetSearchResult.UniqueTargetId){
			case "e424bc49917b4adc89d8c46e3a3a4286" :
				Debug.Log("UFES wins");
			break;
			case "df180bd681a04614968010fcde7a7633" :
				Debug.Log("Batman wins");
			break;
		}
		*/

		//apareceu o marcador, vamos aciona-lo e deesabilitar os outros marcadores
		Debug.Log("achei o target:"+targetSearchResult.UniqueTargetId);

		for (int i = 0; i < objetosA3RA.Count; i++) {
			if (objetosA3RA [i].GetComponent<ObjetoA3RA> ().objetoMultimidia.targetIDObjeto == targetSearchResult.UniqueTargetId) {
				Debug.Log("achei o:"+objetosA3RA [i].name);
				if (objetosA3RA [i].GetComponent<ObjetoA3RA> ().acionado) {
					Debug.Log("o:"+objetosA3RA [i].name+"foi acionado sim");
					if (objetosA3RA [i].GetComponent<ObjetoA3RA> ().souPOI) {
						objetosA3RA [i].GetComponent<ObjetoA3RA> ().objetosRAPossiveis [0].SetActive (true); //poi
					}
					controlaObjetosAumentados (targetSearchResult.UniqueTargetId);
				}
			}
		}

	}

	//entra com o encontrado
	void controlaObjetosAumentados(string id){
		for (int i = 0; i < marcAumenta.objetosAumentado.Count; i++) {
			if (marcAumenta.objetosAumentado [i].targetID == id) {
				marcAumenta.objetosAumentado [i].objetoAumentado.SetActive (true);
				marcAumenta.objetosAumentado [i].objetoAumentado.GetComponent<ObjetoA3RA>().fuiAcionado = true;
				marcAumenta.objetosAumentado [i].objetoAumentado.GetComponent<ObjetoA3RA>().acionado = true;
			} else {
				marcAumenta.objetosAumentado [i].objetoAumentado.SetActive (false);
			}
		}
	}



}