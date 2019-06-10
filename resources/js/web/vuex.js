import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    photos: [],
    avatar: ''
  },
  mutations: {
    fillPhotos (state, photosAction) {
      	state.photos = photosAction
    },
    fillAvatar (state, AvatarAction) {
        state.avatar = AvatarAction
    },
  },
  actions: {
  	getPhotos({ commit }, url){
  		axios.get('/admin/posts/' + url + '/photos')
		  .then(response =>{
			   commit('fillPhotos', response.data)
		  }).catch(errores =>{
			   console.log(errores);
		  });
  	},
    getAvatar({ commit }, user){
      axios.get('/admin/users/' + user + '/avatar')
      .then(response =>{
         commit('fillAvatar', response.data)
      });
    },
  }
});