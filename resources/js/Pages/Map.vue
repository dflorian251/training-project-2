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
	props: {
		initialMarkers: {
			type: Array,
			required: true,
		},
	},
	data() {
		return {
			map: null,
			activeInfoWindow: null,
			markers: [],
		};
	},
	mounted() {
		// Load the Google Maps script
		const api_key = import.meta.env.VITE_GMAPS_API_KEY;
		const script = document.createElement('script');
		script.src = `https://maps.googleapis.com/maps/api/js?key=${api_key}&callback=initMap`;
		script.async = true;
		script.defer = true;
		window.initMap = this.initMap;
		document.head.appendChild(script);
	},
	methods: {
		async initMap() {
			this.map = new google.maps.Map(document.getElementById('map'), {
				center: {
					lat: 39.6243,
					lng: 19.9217
				},
				zoom: 15,
			});

			this.map.addListener('click', this.mapClicked);

            try {
                // Await the getMarkers function to resolve
                let marks = await this.getMarkers();
                this.displayMarkers(marks);
            } catch (error) {
                console.error('Error initializing markers:', error);
            }
		},
        async getMarkers() {
            try {
                // const baseUrl = window.location.origin;
                // const response = await axios.get(`${baseUrl}/get-locations`);
                const response = await axios.get(`/training-project-2/public/get-locations`);
                return response.data;
            } catch (error) {
                // Log and return the error
                console.error('Error fetching markers:', error);
                throw error;  // Rethrow error if you want to handle it elsewhere
            }
        },
        async displayMarkers(marks) {
            if (marks) {
                alert('No locations to display.');
                return this.markers = [];
            }

            for (const marker of marks) {
                console.log(marker.comment);
                const mark = new google.maps.Marker({
                    position: {lat: Number(marker.latitude), lng: Number(marker.longitude)},
                    label: marker.comment,
                    map: this.map,
                });
                console.log(marker);
                this.markers.push(mark);
            }
        },
		// mapClicked(event) {
		// 	console.log(this.map);
		// 	console.log(event.latLng.lat(), event.latLng.lng());
		// },
		// markerClicked(marker, index) {
		// 	console.log(this.map);
		// 	console.log(marker.position.lat());
		// 	console.log(marker.position.lng());
		// },
		// markerDragEnd(event, index) {
		// 	console.log(this.map);
		// 	console.log(event.latLng.lat());
		// 	console.log(event.latLng.lng());
		// },
	},
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
