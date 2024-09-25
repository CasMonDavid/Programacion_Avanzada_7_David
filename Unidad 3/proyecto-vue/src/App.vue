<script setup>
  import { ref, onMounted } from 'vue'
  let movies = ref([])
  let movieDetails = ref([])
  let SessionName = ref('')
  let username = ref('')
  let password = ref('')
  let points = ref(0.0)
  let isLogin = ref(false)
  let isDetails = ref(false)

  function onSubmit(){

    const options = {
      method: 'POST',
      headers: {
        accept: 'application/json',
        'content-type': 'application/json',
        Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZWQ4MDQzMTU0MWViYTZiYjQ0MjE2MWZhYTJjMDA3ZCIsIm5iZiI6MTcyNzI1MTAyOS42NzEzMjksInN1YiI6IjY2ZjJmNzA0YTgyYjAwNTcwMzI3MDA3YiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.UWXKuIEaETJqJXBtAPRUkQD8mR66-gCu_ILi-4CE6AM'
      },
      body: JSON.stringify({
        username: username.value,
        password: password.value,
        request_token: ''
      })
    };

    fetch('https://api.themoviedb.org/3/authentication/token/validate_with_login', options)
      .then(response => response.json())
      .then(response => {
        let responseString = JSON.parse(JSON.stringify(response))
        isLogin.value = true
        SessionName.value = username.value
        sessionStorage.setItem('SessionName',username.value)
        console.log(responseString)
      })
      .catch(err => console.error(err));
  }

  function getMovies(){
    const options = {
      method: 'GET',
      headers: {
        accept: 'application/json',
        Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZWQ4MDQzMTU0MWViYTZiYjQ0MjE2MWZhYTJjMDA3ZCIsIm5iZiI6MTcyNzI1MTAyOS42NzEzMjksInN1YiI6IjY2ZjJmNzA0YTgyYjAwNTcwMzI3MDA3YiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.UWXKuIEaETJqJXBtAPRUkQD8mR66-gCu_ILi-4CE6AM'
      }
    };

    fetch('https://api.themoviedb.org/3/discover/movie?language=es-MX&page=5&sort_by=popularity.desc', options)
      .then(response => response.json())
      .then(response => {
        let responseString = JSON.parse(JSON.stringify(response.results))
        movies.value = responseString
        console.log(movies.value)
      })
      .catch(err => console.error(err));
  }

  function goDetailsMovie(idMovie){
    const options = {
      method: 'GET',
      headers: {
        accept: 'application/json',
        Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZWQ4MDQzMTU0MWViYTZiYjQ0MjE2MWZhYTJjMDA3ZCIsIm5iZiI6MTcyNzI1Mzc0NS4zMDc3NTgsInN1YiI6IjY2ZjJmNzA0YTgyYjAwNTcwMzI3MDA3YiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.aLFNRAfX0zEb8gxVh2_XA3tyjXYT5l6pnkiqydvHazM'
      }
    };

    fetch(`https://api.themoviedb.org/3/movie/${idMovie}?language=es-MX`, options)
      .then(response => response.json())
      .then(response => {
        let responseString = JSON.parse(JSON.stringify(response))
        movieDetails = responseString
        console.log(movieDetails)
        isDetails.value = !isDetails.value
      })
      .catch(err => console.error(err));

  }

  function darValoracion(){
    let valoracion = parseFloat(points.value)
    console.log(valoracion)
    if (valoracion>0){
      const options = {
        method: 'POST',
        headers: {
          accept: 'application/json',
          'Content-Type': 'application/json;charset=utf-8',
          Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZWQ4MDQzMTU0MWViYTZiYjQ0MjE2MWZhYTJjMDA3ZCIsIm5iZiI6MTcyNzI1Mzc0NS4zMDc3NTgsInN1YiI6IjY2ZjJmNzA0YTgyYjAwNTcwMzI3MDA3YiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.aLFNRAfX0zEb8gxVh2_XA3tyjXYT5l6pnkiqydvHazM'
        },
        body: `{"value":${valoracion}}`
      };

      fetch(`https://api.themoviedb.org/3/movie/${movieDetails.id}/rating`, options)
        .then(response => response.json())
        .then(response => {
          console.log(response)
          alert("Gracias por votar")
        })
        .catch(err => console.error(err));
    }else{
      alert("La puntuaciones tienen que ser minimo de 1")
    }
  }

  function deleteValoracion(){
    const options = {
      method: 'DELETE',
      headers: {
        accept: 'application/json',
        'Content-Type': 'application/json;charset=utf-8',
        Authorization: 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhZWQ4MDQzMTU0MWViYTZiYjQ0MjE2MWZhYTJjMDA3ZCIsIm5iZiI6MTcyNzI1Mzc0NS4zMDc3NTgsInN1YiI6IjY2ZjJmNzA0YTgyYjAwNTcwMzI3MDA3YiIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.aLFNRAfX0zEb8gxVh2_XA3tyjXYT5l6pnkiqydvHazM'
      }
    };

    fetch(`https://api.themoviedb.org/3/movie/${movieDetails.id}/rating`, options)
      .then(response => response.json())
      .then(response => {
        let responseString = JSON.parse(JSON.stringify(response))
        console.log(responseString)
        alert("Se elimino tu puntuación")
        points.value = 0
      })
      .catch(err => console.error(err));
  }

  function volverMenu(){
    isDetails.value = false
  }

  onMounted(() => {
    SessionName.value = sessionStorage.getItem("SessionName")

    if (SessionName.value!=undefined){
      console.log("Sesion abierta de: "+SessionName.value)
      isLogin.value = true;
    }

    

    getMovies()

    console.log("los componentes son montados ")
  })
</script>

<template>
  <div class="cuerpo">
    <form v-if="!isLogin" @submit.prevent="onSubmit">
      <div id="titulo">
        <h1>Iniciar sesión</h1>
      </div>
      <fieldset id="campoCorreo">
        <legend for="">Ingresar nombre de usuario</legend>
        <input v-model="username" type="text" placeholder="Nombre de usuario">
      </fieldset>
      <fieldset id="campoPassword">
        <legend for="">Ingresar contraseña</legend>
        <input v-model="password" type="password" placeholder="Contraseña">
      </fieldset>
      <button type="submit">Acceder</button>
    </form>
    <div v-else>
      <h2>Bienvenido {{ SessionName }}</h2>
      <div v-if="!isDetails">
      <h1>PELICULAS:</h1>
      <div class="row"> <!-- Poner el for aqui -->
        
        <div v-for="peli in movies" class="card column">
          <img :src="`https://image.tmdb.org/t/p/w200${peli.poster_path}`" alt="Avatar" style="width:100%">
          <div class="container">
            <h4><b>Título original: {{ peli.original_title }}</b></h4>
            <h4><b>Título: {{ peli.title }}</b></h4>
            <p>Fecha: {{ peli.release_date }}</p>
            <button @click="goDetailsMovie(peli.id)" class="btnDetalles">Detalles</button>
          </div>
        </div>

      </div>
      </div>
      <div v-else class="cuerpoDetalles">
        <div id="contenedorDetalles">
          <div>
            <h1>{{ movieDetails.title }}</h1>
            <img :src="`https://image.tmdb.org/t/p/w200${movieDetails.poster_path}`" alt="">
          </div>
          <div id="detallesInformacion">
            <h3>Fecha: {{ movieDetails.release_date }}</h3>
            <h3>Idioma original: {{ movieDetails.original_language }}</h3>
            <h3>Estado: {{ movieDetails.status }}</h3>
            <h3>¡Dar valoración!: {{ points }}</h3>
            <input v-model="points" type="range" min="1" max="10">
            <button @click="darValoracion" class="btnDetalles" >Confirmar</button>
            <button @click="deleteValoracion" class="btnDetalles" >Eliminar</button>
            <button @click="volverMenu" class="btnDetalles" >Volver</button>
          </div>
        </div>
      </div>
      
    </div>
    
  </div>
</template>

<style scoped>
  .cuerpo{
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: burlywood;
    padding: 30px;
  }
  #titulo{
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  #titulo h1{
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    font-weight: bold;
  }
  #campoCorreo{
    padding-bottom: 10px;
  }
  #campoPassword{
    padding-bottom: 10px;
  }
  h2{
    margin: 10px 0px;
  }

  .column {
    float: left;
    width: 23%;
    padding: 0 10px;
    height: 550px;
  }
  .row {
    margin: 0 -5px;
  }
  .row:after {
    content: "";
    display: table;
    clear: both;
  }
  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    padding: 16px;
    text-align: center;
    background-color: #f1f1f1;
    margin: 5px 5px;
  }
  .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
  }
  .container {
    padding: 2px 16px;
  }

  .btnDetalles{
    font-size: large;
    margin: 2px;
  }

  .cuerpoDetalles{
    background-color: aquamarine;
    width: 100%;
    margin: 0px;
    padding: 0px;
  }
  #contenedorDetalles{
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    width: 100%;
    margin: 20px;
    padding: 10px;
  }
  #detallesInformacion{
    display: flex;
    flex-direction: column;
    align-items: stretch;
    padding: 0px 20px;
    width: 100%;
  }
</style>
