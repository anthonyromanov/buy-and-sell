const firebaseConfig = {
    apiKey: "AIzaSyCF8yH08MOQbibMdFz1DuLgb9IeuYYL49I",
    authDomain: "buyandsell-e942f.firebaseapp.com",
    projectId: "buyandsell-e942f",
    storageBucket: "buyandsell-e942f.appspot.com",
    messagingSenderId: "495872827587",
    appId: "1:495872827587:web:8b701425aa203f3b144276",
    measurementId: "G-SGQ4V51SJT"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);

  // getting the text value from the database
  var bigOne = document.getElementById('bigOne');
  var dbRef = firebase.database().ref().child('text');
  dbRef.on('value', snap => bigOne.innerText = snap.val())