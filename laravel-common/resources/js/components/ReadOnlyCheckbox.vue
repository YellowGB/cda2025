<template>
  <input type="checkbox" :checked="checked" disabled>
</template>

<script>
export default {
  name: 'ReadOnlyCheckbox',
  props: {
      checked: {
          type: Boolean,
          required: true
      }
  },
}
</script>