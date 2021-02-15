<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >
    <v-list dense>
        <v-list-item link @click="logout">
          <v-list-item-action>
            <v-icon>mdi-power</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Log Out {{currentUser.first}}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
    </v-list>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

      <v-toolbar-title>Application {{loggedIn}}</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <!--  -->
    </v-main>
  </v-app>
</template>

<script>
  export default {
    props : {
      source: String,
    },
    data: () => ({ drawer: null }),
    computed: {
      loggedIn: {
        get(){
          return this.$store.state.currentUser.loggedIn;
        }
      },
      currentUser: {
        get(){
          return this.$store.state.currentUser.user;
        }
      }
    },
    methods: {
        logout(){
            // Axios comes preinstalled with Laravel
            axios.post('/logout')
            .then(response => {
                // After successful request
                window.location.href = "login"
            });
        }
    },
    created(){
      axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("blog_token");
      this.$store.dispatch('currentUser/getUser');
    }
  }
</script>