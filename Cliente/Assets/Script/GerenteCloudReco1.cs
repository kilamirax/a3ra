using UnityEngine;
using System.Collections;
using Vuforia;
using System.Collections.Generic;

public class GerenteCloudReco1 : MonoBehaviour, ICloudRecoEventHandler {
	
	private CloudRecoBehaviour mCloudRecoBehaviour;
	private ObjectTracker mObjectTracker;
	private ImageTargetBehaviour imageTargetBehaviour;
	private GameObject ImageTargetData;

	private bool mIsScanning = false;
	private string mTargetMetadata = "";
	public ImageTargetBehaviour ImageTargetTemplate; /// Can be set in the Unity inspector to reference a ImageTargetBehaviour that is used for augmentations of new cloud reco results.

	private bool mMustRestartApp = false;

	public List <GameObject> objetosA3RA = new List<GameObject>();
	public GerenteMarcadorAumenta imageTargetCloud;
	string targetIdLido;

	// Use this for initialization
	void Start () {
		// register this event handler at the cloud reco behaviour
		mCloudRecoBehaviour = GetComponent<CloudRecoBehaviour>();

		ImageTargetData = Instantiate(ImageTargetTemplate.gameObject) as GameObject;

		if (mCloudRecoBehaviour)
			mCloudRecoBehaviour.RegisterEventHandler(this);

//		if (imageTargetCloud == null)
//			imageTargetCloud = GameObject.Find ("ImageTargetCloud").GetComponent<GerenteMarcadorAumenta> ();
	}
    
	#region ICloudRecoEventHandler_implementation
	/// Called when TargetFinder has been initialized successfully
	public void OnInitialized() {
		Debug.Log ("Cloud Reco initialized");
		mObjectTracker = TrackerManager.Instance.GetTracker<ObjectTracker>();

        //mContentManager = FindObjectOfType<ContentManager>();
	}
	/// Called if Cloud Reco initialization fails
	public void OnInitError(TargetFinder.InitState initError) {
		Debug.Log ("Cloud Reco init error " + initError.ToString());
		switch (initError){
            case TargetFinder.InitState.INIT_ERROR_NO_NETWORK_CONNECTION:{
                    mMustRestartApp = true;
					Debug.Log("Network Unavailable - Please check your internet connection and try again.");
                    break;
                }
            case TargetFinder.InitState.INIT_ERROR_SERVICE_NOT_AVAILABLE:
			Debug.Log("Service Unavailable - Failed to initialize app because the service is not available.");
                break;
        }
	}
	
	/// Called if a Cloud Reco update error occurs
	public void OnUpdateError(TargetFinder.UpdateState updateError) {
		Debug.Log ("Cloud Reco update error " + updateError.ToString());
		switch (updateError){
            case TargetFinder.UpdateState.UPDATE_ERROR_AUTHORIZATION_FAILED:
			Debug.Log("Authorization Error - The cloud recognition service access keys are incorrect or have expired.");
                break;
            case TargetFinder.UpdateState.UPDATE_ERROR_NO_NETWORK_CONNECTION:
			Debug.Log("Network Unavailable - Please check your internet connection and try again.");
                break;
            case TargetFinder.UpdateState.UPDATE_ERROR_PROJECT_SUSPENDED:
			Debug.Log("Authorization Error - The cloud recognition service has been suspended.");
                break;
            case TargetFinder.UpdateState.UPDATE_ERROR_REQUEST_TIMEOUT:
			Debug.Log("Request Timeout - The network request has timed out, please check your internet connection and try again.");
                break;
            case TargetFinder.UpdateState.UPDATE_ERROR_SERVICE_NOT_AVAILABLE:
			Debug.Log("Service Unavailable - The service is unavailable, please try again later.");
                break;
            case TargetFinder.UpdateState.UPDATE_ERROR_TIMESTAMP_OUT_OF_RANGE:
			Debug.Log("Clock Sync Error - Please update the date and time and try again.");
                break;
            case TargetFinder.UpdateState.UPDATE_ERROR_UPDATE_SDK:
			Debug.Log("Unsupported Version - The application is using an unsupported version of Vuforia.");
                break;
        }
	}

	 /// when we start scanning, unregister Trackable from the ImageTargetTemplate, then delete all trackables
	public void OnStateChanged(bool scanning) {
		mIsScanning = scanning;

		if (scanning) {
			// clear all known trackables
			Debug.Log("estou scaneando");
			mObjectTracker.TargetFinder.ClearTrackables (false);
			//mCloudRecoBehaviour.CloudRecoEnabled = false;
			// hide the ImageTargetTemplate
			//mContentManager.ShowObject(false);
		}
	}

	/// Handles new search results
	// Here we handle a cloud target recognition event
	public void OnNewSearchResult(TargetFinder.TargetSearchResult targetSearchResult) {
		// This code demonstrates how to reuse an ImageTargetBehaviour for new search results and modifying it according to the metadata
        // Depending on your application, it can make more sense to duplicate the ImageTargetBehaviour using Instantiate(), 
        // or to create a new ImageTargetBehaviour for each new result

        // Vuforia will return a new object with the right script automatically if you use
        // TargetFinder.EnableTracking(TargetSearchResult result, string gameObjectName)


		//Check if the metadata isn't null
		if (targetSearchResult.MetaData == null) {
			Debug.Log ("Target metadata not available.");
			return;
		}

		// duplicate the referenced image target
		GameObject newImageTarget = Instantiate(ImageTargetTemplate.gameObject) as GameObject;

		//GameObject augmentation = null;

		string model_name = targetSearchResult.MetaData;

		/*
		if( augmentation != null )
			augmentation.transform.parent = newImageTarget.transform;
*/
		// enable the new result with the same ImageTargetBehaviour:
		//ImageTargetBehaviour imageTargetBehaviour = mImageTracker.TargetFinder.EnableTracking(targetSearchResult, newImageTarget);
		imageTargetBehaviour = 
			(ImageTargetBehaviour)mObjectTracker.TargetFinder.EnableTracking(targetSearchResult, newImageTarget);



		Debug.Log("Metadata value is " + model_name );



		switch(targetSearchResult.UniqueTargetId){

		case "e424bc49917b4adc89d8c46e3a3a4286" :
			Debug.Log("UFES wins");
			//Destroy( imageTargetBehaviour.gameObject.transform.Find("Dragon").gameObject );

			break;

		case "df180bd681a04614968010fcde7a7633" :
			Debug.Log("Batman wins");
			//Destroy( imageTargetBehaviour.gameObject.transform.Find("teapot").gameObject );

			break;

		}
		/*
		if (imageTargetBehaviour != null)
		{
			// stop the target finder
			mCloudRecoBehaviour.CloudRecoEnabled = false;
		}
		*/

		/*
		ImageTargetData.name = targetSearchResult.UniqueTargetId;

		//Check if the metadata isn't null
		if (targetSearchResult.MetaData == null) {
			Debug.Log ("Target metadata not available.");
			return;
		} else {
			mTargetMetadata = targetSearchResult.MetaData;
		}
*/

		//UFESIcone.jpg Target ID: 46739312240648fab508760b71ac1b1a
		//BatmanLegoMovie.jpg Target ID: 12120a84c4f649d09519cb813d25bda1
		/*
		switch (targetSearchResult.UniqueTargetId){
		case "46739312240648fab508760b71ac1b1a":
			{
				objetosAumentados[0].gameObject.SetActive(false);
				objetosAumentados[1].gameObject.SetActive(true);
				break;
			}
		case "12120a84c4f649d09519cb813d25bda1":
			{
				objetosAumentados[0].gameObject.SetActive(true);
				objetosAumentados[1].gameObject.SetActive(false);
				break;
			}
		}
*//*
		//apareceu o marcador, vamos aciona-lo e deesabilitar os outros marcadores
		Debug.Log("achei o target:"+targetSearchResult.UniqueTargetId);
		if (targetIdLido != targetSearchResult.UniqueTargetId) {
			targetIdLido = targetSearchResult.UniqueTargetId;
			for (int i = 0; i < objetosA3RA.Count; i++) {
				if (objetosA3RA [i].GetComponent<ObjetoA3RA> ().acionado) {
					if (objetosA3RA [i].GetComponent<ObjetoA3RA> ().objetoMultimidia.targetIDObjeto == targetIdLido) {
						if (objetosA3RA [i].GetComponent<ObjetoA3RA> ().souPOI) {
							objetosA3RA [i].GetComponent<ObjetoA3RA> ().objetosRAPossiveis [0].SetActive (true); //poi
						}
						controlaObjetosAumentados (targetIdLido);
					}
				}
			}
		}
		*/
		/*
		imageTargetBehaviour =
			(ImageTargetBehaviour)mObjectTracker.TargetFinder.EnableTracking(
				targetSearchResult, ImageTargetTemplate.gameObject);

		if (imageTargetBehaviour == null) {
			mCloudRecoBehaviour.CloudRecoEnabled = false;
		}
		*/

		/*testes
			Debug.Log("targetSearchResult.MetaData = "+targetSearchResult.MetaData);
			Debug.Log("targetSearchResult.TargetName = "+targetSearchResult.TargetName);
			Debug.Log("targetSearchResult.UniqueTargetId = "+targetSearchResult.UniqueTargetId);
			Debug.Log("targetSearchResult.TrackingRating = "+targetSearchResult.TrackingRating);
			Debug.Log("targetSearchResult.TargetSearchResultPtr = "+targetSearchResult.TargetSearchResultPtr);
		*/
	}
	#endregion //ICloudRecoEventHandler_implementation

	//entra com o encontrado
	void controlaObjetosAumentados(string id){
		for (int i = 0; i < imageTargetCloud.objetosAumentado.Count; i++) {
			if (imageTargetCloud.objetosAumentado [i].targetID == id) {
				imageTargetCloud.objetosAumentado [i].objetoAumentado.SetActive (true);
				imageTargetCloud.objetosAumentado [i].objetoAumentado.GetComponent<ObjetoA3RA>().fuiAcionado = true;
				imageTargetCloud.objetosAumentado [i].objetoAumentado.GetComponent<ObjetoA3RA>().acionado = true;
			} else {
				imageTargetCloud.objetosAumentado [i].objetoAumentado.SetActive (false);
			}
		}
	}

	/*
	void OnGUI() {
		// Display current 'scanning' status
		GUI.Box (new Rect(0,100,200,25), mIsScanning ? "Scanning" : "Not scanning");
		// Display metadata of latest detected cloud-target
		GUI.Box (new Rect(0,200,200,25), "Metadata: " + mTargetMetadata);
		// If not scanning, show button
		// so that user can restart cloud scanning
		if (!mIsScanning) {
			if (GUI.Button(new Rect(100,300,200,50), "Restart Scanning")) {
				// Restart TargetFinder
				mCloudRecoBehaviour.CloudRecoEnabled = true;
			}
		}
	}
    */
}
