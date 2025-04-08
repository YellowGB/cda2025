<template>
  <div>
      <h1>Rooms</h1>
      <div v-if="loading">Loading...</div>
      <div v-else>
          <div v-for="room in rooms" :key="room.id">
              <router-link :to="{ name: 'room-detail', params: { id: room.id }}">
                  {{ room.name }}
              </router-link>
          </div>
      </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  name: 'RoomsList',
  setup() {
      const rooms = ref([]);
      const loading = ref(true);

      const fetchRooms = async () => {
          try {
              const response = await axios.get('/api/rooms');
              rooms.value = response.data.rooms;
          } catch (error) {
              console.error('Error fetching rooms:', error);
          } finally {
              loading.value = false;
          }
      };

      onMounted(() => {
          fetchRooms();
      });

      return {
          rooms,
          loading
      };
  }
}
</script>