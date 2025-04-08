import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';

import RoomsList from './pages/RoomsList.vue';
import RoomDetail from './pages/RoomDetail.vue';

const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/rooms',
      name: 'rooms',
      component: RoomsList
    },
    {
      path: '/room/:id',
      name: 'room-detail',
      component: RoomDetail,
      props: true
    }
  ]
});

const app = createApp(App);
app.use(router);
app.mount('#app');