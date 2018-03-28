<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Picker Example</title>

    <script type="text/javascript">

  var developerKey = 'AIzaSyBZKKLMyZ5e7uLc9o1P7k2xXDUv7Nrqllw';

      // The Client ID obtained from the Google API Console. Replace with your own Client ID.
	var clientId = '529550955510-9ija4ahk5renm1asptbllo51ef7ogq1h.apps.googleusercontent.com';
    var appId = "529550955510";

    // Scope to use to access user's Drive items.
    var scope = ['https://www.googleapis.com/auth/drive.readonly'];

    var pickerApiLoaded = false;
    var oauthToken;

    // Use the Google API Loader script to load the google.picker script.
    function loadPicker() {
      gapi.load('auth', {'callback': onAuthApiLoad});
      gapi.load('picker', {'callback': onPickerApiLoad});
    }

    function onAuthApiLoad() {
      window.gapi.auth.authorize(
          {
            'client_id': clientId,
            'scope': scope,
            'immediate': false
          },
          handleAuthResult);
    }

    function onPickerApiLoad() {
      pickerApiLoaded = true;
      createPicker();
    }

    function handleAuthResult(authResult) {
      if (authResult && !authResult.error) {
        oauthToken = authResult.access_token;
        createPicker();
      }
    }

    // Create and render a Picker object for searching images.
    function createPicker() {
      if (pickerApiLoaded && oauthToken) {
        var view = new google.picker.View(google.picker.ViewId.DOCS);
        // view.setMimeTypes("application/vnd.google-apps.document,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        // view.setMimeTypes("image/png,image/jpeg,image/jpg,application/vnd.google-apps.document");
		
        var picker = new google.picker.PickerBuilder()
            .enableFeature(google.picker.Feature.NAV_HIDDEN)
            .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
            .setAppId(appId)
            .setOAuthToken(oauthToken)
            .addView(view)
            .addView(new google.picker.DocsUploadView())
            .setDeveloperKey(developerKey)
            .setCallback(pickerCallback)
            .build();
         picker.setVisible(true);
      }
    }

    // A simple callback implementation.
    function pickerCallback(data) {
      if (data.action == google.picker.Action.PICKED) {
        var fileId = data.docs[0].id;
		var mimeType = data.docs[0].mimeType;
		window.open('https://docs.google.com/document/d/'+fileId,'_blank');
        location.reload();
      }
    }
    </script>
  </head>
  <body>
    <div id="result"></div>

    <!-- The Google API Loader script. -->
    <script type="text/javascript" src="https://apis.google.com/js/api.js?onload=loadPicker"></script>
  </body>
</html>
