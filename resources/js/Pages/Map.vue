<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


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
		initMap() {
			this.map = new google.maps.Map(document.getElementById('map'), {
				center: {
					lat: 39.6243,
					lng: 19.9217
				},
				zoom: 15,
			});

			this.map.addListener('click', this.mapClicked);

			this.getMarkers();
		},
        async getMarkers() {
            try {
                await axios.get(`/training-project-2/public/get-locations`)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            } catch (error) {
                console.error('Error deleting user:', error);
            }

        },
		// initMarkers() {
		// 	for (let index = 0; index < this.initialMarkers.length; index++) {
		// 		const markerData = this.initialMarkers[index];
		// 		const marker = new google.maps.Marker({
		// 			position: markerData.position,
		// 			label: markerData.label,
		// 			draggable: markerData.draggable,
		// 			map: this.map,
		// 		});
		// 		this.markers.push(marker);

		// 		const infowindow = new google.maps.InfoWindow({
		// 			content: `<b>${markerData.position.lat}, ${markerData.position.lng}</b>`,
		// 		});
		// 		marker.addListener('click', () => {
		// 			if (this.activeInfoWindow) {
		// 				this.activeInfoWindow.close();
		// 			}
		// 			infowindow.open(this.map, marker);
		// 			this.activeInfoWindow = infowindow;
		// 			this.markerClicked(marker, index);
		// 		});

		// 		marker.addListener('dragend', (event) => {
		// 			this.markerDragEnd(event, index);
		// 		});
		// 	}
		// },
		mapClicked(event) {
			console.log(this.map);
			console.log(event.latLng.lat(), event.latLng.lng());
		},
		markerClicked(marker, index) {
			console.log(this.map);
			console.log(marker.position.lat());
			console.log(marker.position.lng());
		},
		markerDragEnd(event, index) {
			console.log(this.map);
			console.log(event.latLng.lat());
			console.log(event.latLng.lng());
		},
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
