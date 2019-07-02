<template>
	<v-container fluid>
		<v-layout align-center justify-center row>
			<v-flex xs12>
				<h1 class="primary--text">Hotel</h1>
				<v-divider></v-divider>
			</v-flex>
		</v-layout>
		<v-layout row justify-center>
			<v-alert v-cloak :value="alert.show" :type="alert.type" dismissible>
				{{ alert.message }}
			</v-alert>
		</v-layout>
		<v-layout column fill-height justify-center>
			<v-flex xs12>
				<v-form style="min-width: 400px;" v-on:submit.prevent="updateHotel">
					<v-flex xs12>
						<v-text-field
							v-model="hotel.name"
							label="Name"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12>
						<v-text-field
							v-model="hotel.address"
							label="Address"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12>
						<v-text-field
							v-model="hotel.city"
							label="City"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12>
						<v-text-field
							v-model="hotel.state"
							label="State"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12>
						<v-text-field
							v-model="hotel.country"
							label="Country"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12>
						<v-text-field
							v-model="hotel.zipcode"
							label="Zip Code"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12>
						<v-text-field
							v-model="hotel.phone"
							label="Phone"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12>
						<v-text-field
							v-model="hotel.email"
							label="Email"
							required
							type="email"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12 md8>
						<v-img :src="hotel.image" aspect-ratio="2" contain></v-img>
					</v-flex>
					<v-flex xs12>
						<v-btn
              outline
              class="upload-button text-none"
              background-color="white"
              @click="selectFile"
            >
              <v-icon dark class="mr-2">cloud_upload</v-icon>
              <span>Update Hotel Image</span>
            </v-btn>
            <input
              type="file"
              style="display:none"
              ref="hotelImage"
              accept="image/*"
              id="image1"
              @change="onFilePicked"
            />
					</v-flex>

					<v-flex xs12 sm6 md4>
						<v-btn large dark type="submit" color="info">Update Hotel</v-btn>
					</v-flex>
				</v-form>
			</v-flex>
		</v-layout>
	</v-container>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";

export default {
	data() {
		return {
			hotel: {},
			alert: { type: "error", show: false, message: null },
			newImage: null,
		}
	},
	created() {
		let vm = this;
		this.checkAuthentication();
		axios.get(vm.apiRoot + "/hotel", {
			headers: {
				Authorization: "Bearer " + vm.token
			}
		})
		.then(response => {
			vm.hotel = response.data;
		})
		.catch(error => {
			vm.alert = {type: "error", show: true, message: "An error occured. Refresh page and try again." };
		})
	},
	computed: {
    ...mapGetters({}),
		...mapState('auth', ['token','user']),
		...mapState(['apiRoot']),
	},
	methods: {
		...mapMutations('auth', ['checkAuthentication']),
		...mapActions({}),
		updateHotel()
		{
			let vm = this;
			let formData = new FormData();
			formData.append('id', vm.hotel.id)
			formData.append('name', vm.hotel.name);
			formData.append('address', vm.hotel.address);
			formData.append('city', vm.hotel.city);
			formData.append('state', vm.hotel.state);
			formData.append('country', vm.hotel.country);
			formData.append('zipcode', vm.hotel.zipcode);
			formData.append('phone', vm.hotel.phone);
			formData.append('email', vm.hotel.email);
			if (vm.newImage !== null) {
				formData.append('image', vm.newImage);
			}
			

			axios.post(vm.apiRoot + "/hotel/" + vm.hotel.id, formData, {
				headers: {
					"Content-Type" : "multipart/form-data",
					Authorization: "Bearer " + vm.token,
				}
			})
			.then(response => {
				vm.alert = {type: "success", show: true, message: response.data.message };
				vm.hotel = response.data.hotel;
			})
			.catch(error => {
				if (error.response !== undefined) {
					console.log(error.response)
					vm.alert = {type: "error", show: true, message: error.response.data.message + ". " + error.response.data.validation_messages};
				} else {
					vm.alert = {type: "error", show: true, message: "An error occured. Refresh page and try again." };
				}
			})
		},
		selectFile()
    {
      this.$refs.hotelImage.click()
    },
    onFilePicked(e)
    {
      const files = this.$refs.hotelImage.files;
      if(files[0] !== undefined) {
        this.newImage = files[0];
      } else {
        this.newImage = "";
      }  
    },
	}
}
</script>