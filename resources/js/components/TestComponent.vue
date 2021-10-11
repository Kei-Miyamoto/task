<template>
  <div id="app">
    <p>aiueo</p>
    <h1>{{ test }}</h1>
  </div>
</template>

<script>
  const app = new Vue ({
    el: "#app",
    data: {
      test: "アイウエオ",
    }
  })
  
</script>