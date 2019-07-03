<template>
	<v-container fluid>
		<v-layout align-center justify-center row>
			<v-flex xs12>
				<h1 class="primary--text">Rooms</h1>
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
				<v-form v-on:submit.prevent="createRoom" style="padding-top:10px;">
					<v-flex xs12 md4>
						<v-text-field
							v-model="newRoom.name"
							label="Name"
							required
							type="text"
							outline
						></v-text-field>
					</v-flex>

					<v-flex xs12 md4>
						<v-select
							v-model="newRoom.room_type_id"
							item-text="name"
							item-value="id"
							:items="roomTypes"
							label="Room Type"
							outline
						></v-select>
					</v-flex>

					<v-flex xs12 md4>
						<v-btn
              outline
              class="upload-button text-none"
              background-color="white"
              @click="selectFile"
            	>
              <v-icon dark class="mr-2">cloud_upload</v-icon>
              <span>New Room Image</span>
            </v-btn>
            <input
              type="file"
              style="display:none"
              ref="newRoomImage"
              accept="image/*"
              @change="onFilePicked"
            />
					</v-flex>

					<v-flex xs12 sm6 md4>
						<v-btn large dark type="submit" color="info">Create New Room</v-btn>
					</v-flex>

				</v-form>
			</v-flex>
		</v-layout>

		<v-layout column fill-height justify-center>
			<v-data-table
			:headers="roomsHeaders"
			:items="rooms">
				<template v-slot:headers="props">
					<tr>
						<th v-for="header in props.headers" :key="header.text">
							{{ header.text }}
						</th>
					</tr>
				</template>

				<template v-slot:items="props">
					<tr>
						<td>
							<v-text-field
							v-model="props.item.name"
							label="Name"
							required
							type="text"
							outline
							></v-text-field>
						</td>

						<td>
							<v-select
							v-model="props.item.room_type_id"
							item-text="name"
							item-value="id"
							:items="roomTypes"
							label="Room Type"
							outline
						></v-select>
						</td>

						<td>
							<a :href="props.item.image"><v-img :src="props.item.image" aspect-ratio="2" contain></v-img></a>
						</td>

						<td>
							<v-btn
              outline
              class="upload-button text-none"
              background-color="white"
              @click="selectFileForUpdate('room_image_' + props.item.id)"
            	>
              <v-icon dark class="mr-2">cloud_upload</v-icon>
              <span>Update Room Image</span>
            </v-btn>
            <input
              type="file"
              style="display:none"
              :ref="'room_image_' + props.item.id"
              accept="image/*"
              @change="onFilePickedForUpdate(props.item, 'room_image_' + props.item.id)"
            />
						</td>

						<td><v-btn dark color="warning" @click="editRoom(props.item)">Edit Room</v-btn> <v-btn dark color="error" @click="deleteRoom(props.item)">Delete Room</v-btn></td>
					</tr>
				</template>
			</v-data-table>
		</v-layout>
	</v-container>
</template>

<script>
import { mapState, mapMutations, mapGetters, mapActions } from "vuex";
import _ from "lodash";

export default {
	data() {
		return {
			newRoom: {name: "", room_type_id: "", image: null},
			alert: { type: "error", show: false, message: null },
			roomTypes: [],
			rooms: [],
			roomsHeaders: [
				{text: "Name", value: "name"},
				{text: "Room Type", value: "room_type_id"},
				{text: "Current Image", value: "image"},
				{text: "New Image", value: null},
				{text: "Action", value: null},
			],
		}
	},
	created() {
		this.checkAuthentication();
		this.fetchRoomTypes();
		this.fetchRooms();
	},
	computed: {
    ...mapGetters({}),
		...mapState(['apiRoot']),
		...mapState('auth', ['token']),
	},
	methods: {
		...mapMutations('auth', ['checkAuthentication']),
		...mapActions({}),
		fetchRoomTypes()
		{
			let vm = this;
			axios.get(vm.apiRoot + '/room-types', {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.roomTypes = response.data;
			})
			.catch(error => {
				console.log(error);
			});
		},
		fetchRooms()
		{
			let vm = this;
			axios.get(vm.apiRoot + '/rooms', {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				vm.rooms = response.data;
				vm.rooms = vm.rooms.map(room => { room.new_image = null; return room; });//this is done to handle picture updates
			})
			.catch(error => {
				console.log(error);
			});
		},
		selectFile()
		{
			this.$refs.newRoomImage.click()
		},
		onFilePicked()
		{
			const files = this.$refs.newRoomImage.files;
      if(files[0] !== undefined) {
        this.newRoom.image = files[0];
      } else {
        this.newRoom.image = null;
			}  
		},
		selectFileForUpdate(refId)
		{
			this.$refs[refId].click()
		},
		onFilePickedForUpdate(fileOwner, refId)
		{
			const files = this.$refs[refId].files;
      if(files[0] !== undefined) {
        fileOwner.new_image = files[0];
      } else {
        fileOwner.new_image = null;
      }  
		},
		createRoom()
		{
			let vm = this;
			let formData = new FormData();
			formData.append('name', vm.newRoom.name);
			formData.append('room_type_id', vm.newRoom.room_type_id);
			formData.append('image', vm.newRoom.image);

			axios.post(vm.apiRoot + "/rooms/", formData, {
				headers: {
					"Content-Type" : "multipart/form-data",
					Authorization: "Bearer " + vm.token,
				}
			})
			.then(response => {
				vm.rooms.unshift(response.data.room);
				vm.newRoom.name = "";
				vm.newRoom.room_type_id = "";
				vm.newRoom.image = null;
				vm.alert = {type: "success", show: true, message: response.data.message };
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
		editRoom(roomDetails)
		{
			let vm = this;
			let formData = new FormData();
			formData.append('id', roomDetails.id)
			formData.append('name', roomDetails.name);
			formData.append('room_type_id', roomDetails.room_type_id);
			if(roomDetails.new_image) {
				formData.append('image', roomDetails.new_image);
			}
			
			axios.post(vm.apiRoot + '/rooms/' + roomDetails.id, formData, {
				headers: {
					"Content-Type" : "multipart/form-data",
					Authorization: "Bearer " + vm.token,
				}
			})
			.then(response => {
				this.fetchRooms();
				vm.alert = {type: "success", show: true, message: response.data.message };
			})
			.catch(error => {
				if (error.response !== undefined) {
					console.log(error.response)
					vm.alert = {type: "error", show: true, message: error.response.data.message + ". " + error.response.data.validation_messages};
				} else {
					console.log(error)
					vm.alert = {type: "error", show: true, message: "An error occured. Refresh page and try again." };
				}
			});
		},
		deleteRoom(roomDetails)
		{
			let vm = this;
			axios.post(vm.apiRoot + '/rooms/delete/' + roomDetails.id, {id: roomDetails.id}, {
				headers: {
					Authorization: "Bearer " + vm.token
				}
			})
			.then(response => {
				var index = _.findIndex(vm.rooms , {id: roomDetails.id});
				vm.rooms.splice(index, 1);
				vm.alert = {type: "success", show: true, message: response.data.message };
			})
			.catch(error => {
				if (error.response !== undefined) {
					console.log(error.response)
					vm.alert = {type: "error", show: true, message: error.response.data.message + ". " + error.response.data.validation_messages};
				} else {
					console.log(error)
					vm.alert = {type: "error", show: true, message: "An error occured. Refresh page and try again." };
				}
			});
		}
	}
}
</script>