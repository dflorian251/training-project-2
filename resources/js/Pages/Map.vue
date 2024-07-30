<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';

</script>

<template>
	<AuthenticatedLayout>
	  <div>
		<h1 class="text-center">Laravel Google Maps</h1>
		<div id="map"></div>
	  </div>
	</AuthenticatedLayout>
</template>

  <script>
  export default {
	  name: 'GoogleMap',
	  mounted() {
		  window.initMap = this.initMap.bind(this);

		  const api_key = import.meta.env.VITE_GMAPS_API_KEY;
		  const script = document.createElement('script');
		  script.src = `https://maps.googleapis.com/maps/api/js?key=${api_key}&loading=async&callback=initMap`;
		  script.async = true;
		  script.onload = () => {
			  console.log('Google Maps API script loaded.');
		  };
		  script.onerror = (error) => {
			  console.error('Error loading Google Maps API script:', error);
		  };
		  document.head.appendChild(script);
	  },
	  methods: {
		  async initMap() {
			  console.log('initMap function is called');
			  this.map = new google.maps.Map(document.getElementById('map'), {
				  center: { lat: 39.6243, lng: 19.9217 },
				  zoom: 15,
			  });

			  try {
				  let marks = await this.getMarkers();
				  this.displayMarkers(marks);
			  } catch (error) {
				  console.error('Error initializing markers:', error);
			  }
		  },
		  async getMarkers() {
			  try {
				  const response = await axios.get(`/training-project-2/public/get-locations`);
				  return response.data;
			  } catch (error) {
				  console.error('Error fetching markers:', error);
				  throw error;
			  }
		  },
		  async displayMarkers(marks) {
			  if (!marks || marks.length === 0) {
				  alert('No locations to display.');
				  return;
			  }

			  for (const marker of marks) {
				  const mark = new google.maps.Marker({
					  position: { lat: Number(marker.latitude), lng: Number(marker.longitude) },
					  label: marker.comment,
					  map: this.map,
				  });
				  this.markers.push(mark);
			  }
		  }
	  }
  };
  </script>

  <style>
  .text-center {
	text-align: center;
  }
  #map {
	width: 100%;
	height: 400px;
  }
  </style>
