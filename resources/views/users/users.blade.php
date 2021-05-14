<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>Laravel</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> 
      
    </head>

<body>

<!-- HEADER -->
<header class="header"> <!--header per contenuto di navigazione -->
    <nav class="header__nav"> <!--lista di link -->
    <ul>
            <li>Dashboard</li>
            <li><a href="{{ route('users.create') }}">Aggiungi</a></li>
            <li>Impostazioni</li>
        </ul>


    </nav>



</header> 
<div class="content">
<table id="table">
    <caption>Lista utenti</caption>
    <input class="custom-input" type="text" onchange="onInputChange()"> 

    <tr>
        <th scope="col">Nome</th>
        <th scope="col">Cognome</th>
        <th scope="col">Email</th>
        <th scope="col">Azioni</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{$user->name}}</td>
            <td>{{$user->surname}}</td>
            <td>{{$user->email}}</td>
            <td>
                <a href="{{ route('users.edit',['user' => $user]) }}">Modifica</a>
                <button class="elimina" onclick="deleteFunction()">Elimina</button> 
            </td>
        </tr>
    @endforeach
</table>
</div>

</body>
</html>

<style>
    
    
</style>

<script>

function onInputChange(e) {
    console.log(e.target.value);
}
/*function deleteFunction(e) {
    console.log(e.target.value);
}*/

/*const button = document.getElementsById('elimina')
console.log(elimina);*/

const table = document.getElementById('table')
console.log(table);

let inputs = document.getElementsByClassName("custom-input")
console.log(inputs);

/*let  = document.getElementsByClassName("elimina")
console.log();*/

/*document.getElementById("elimina").deleteRow(0);
button.deleteRow(0);*/

document.getElementById("table").deleteRow(0);
//table.deleteRow(0); 

/*document.getElementByClassName("elimina");
elimina.deleteRow(0);*/

//inputs[0].addEventListener('input', deleteFunction);

inputs[0].addEventListener('input', onInputChange);


table.append("<tr><td></td></tr>") 
</script> 