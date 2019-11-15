<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.2/tailwind.min.css'/>
    <title>Document</title>
</head>
<body>
    
<div class="leading-loose">
  <form class="max-w-xl m-4 p-10 bg-white rounded shadow-xl" method="post" action="" enctype="multipart/form-data">
    <p class="text-gray-800 font-medium">Ajouter un contact</p>
    <div class="inline-block mt-2 w-1/2 pr-1">
      <label class="hidden block text-sm text-gray-600" for="nom">Nom</label>
      <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="nom" name="nom" type="text" required="" placeholder="Nom" aria-label="Name">
    </div>
    <div class="inline-block mt-2 -mx-1 pl-1 w-1/2">
      <label class="hidden block text-sm text-gray-600" for="prenom">Prenom</label>
      <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" id="prenom"  name="prenom" type="text" required="" placeholder="Prénom" aria-label="Name">
    </div>
    <div class="">
      <label class="block text-sm text-gray-00" for="telephone">Numero tel.</label>
      <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="telephone" name="telephone" type="text" required="" placeholder="N° tel." aria-label="Email" pattern="[0-9]{10}">
    </div>
    <div class="mt-2">
      <label class="block text-sm text-gray-600" for="email">Email</label>
      <input class="w-full px-5  py-4 text-gray-700 bg-gray-200 rounded" id="email" name="email" type="address" required="" placeholder="Adresse mail" aria-label="Email">
    </div>
    <div class="mt-2">
      <label class=" block text-sm text-gray-600" for="type_contact">Type de contact</label>
      <select class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" name="type_contact" id="type_contact">
        <option value="ami">Ami</option>
        <option value="famille">Famille</option>
        <option value="professionnel">Professionnel</option>
        <option value="autre">Autre</option>
    </select><br>
    </div>
    <div class="mt-2">
      <label class="text-sm block text-gray-600" for="photo">Photo</label>
      <input class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" type="file" name="photo" id="photo" accept=".jpg, .jpeg, .png"><br>
    </div>
    <div class="mt-4">
      <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit" value="enregistrer"> Enregistrer </button>
    </div>
  </form>
</div>
</body>
</html>