<template>
  <div>
      <div v-if="loading">Loading...</div>
      <div v-else-if="room">
          <h2>{{ room.name }}</h2>
          <ReadOnlyCheckbox :checked="room.is_booked" />
      </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ReadOnlyCheckbox from '../components/ReadOnlyCheckbox.vue';

export default {
  name: 'RoomDetail',
  components: {
    ReadOnlyCheckbox
  },
  props: {
      id: {
          type: String,
          required: true
      }
  },
  setup(props) {
      const room = ref(null);
      const loading = ref(true);

      const fetchRoom = async () => {
          try {
              const response = await axios.get(`/api/room/${props.id}`);
              room.value = response.data;
          } catch (error) {
              console.error('Error fetching room:', error);
          } finally {
              loading.value = false;
          }
      };

      onMounted(() => {
          fetchRoom();
      });

      return {
          room,
          loading
      };
  }
}
</script>