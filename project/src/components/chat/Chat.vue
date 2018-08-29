<template>
  <sui-container >
    <sui-divider hidden />
    <sui-grid :columns="3" divided>
      <sui-grid-row stretched>
        <sui-grid-column :width="4">
          <sui-segment id="team-lists-box">
            <chat-room-list></chat-room-list>
          </sui-segment>
          <sui-segment id="team-members-box">
            <user-list></user-list>
          </sui-segment>
        </sui-grid-column>
        <sui-grid-column :width="12">
          <sui-segment id="chat-history">
            <sui-message
              class="self"
              icon="inbox"
              header="Have you heard about our mailing list?"
            />
            <sui-message
              class="other"
              icon="inbox"
              header="Have you heard about our mailing list?"
            />
            <sui-message
              class="other"
              icon="inbox"
              content="Get the best news in your e-mail every day."
            />
            <sui-message
              class="self"
              icon="inbox"
              content="Get the best news in your e-mail every day."
            />
            <sui-message
              class="other"
              icon="inbox"
              content="Get the best news in your e-mail every day."
            />
            <sui-message
              class="self"
              icon="inbox"
              content="Get the best news in your e-mail every day."
            />
            <sui-message
              class="self"
              icon="inbox"
              content="Get the best news in your e-mail every day."
            />
            <sui-message
              class="other"
              icon="inbox"
              content="Get the best news in your e-mail every day."
            />
            <sui-message
              class="self"
              icon="inbox"
              content="Get the best news in your e-mail every day."
            />
          </sui-segment>
          <sui-segment>
            <sui-grid-row>
              <sui-form>
                <sui-form-field>
                  <sui-input placeholder="Type message here..." size="large" icon="location arrow" />
                </sui-form-field>
              </sui-form>
            </sui-grid-row>
          </sui-segment>
        </sui-grid-column>
      </sui-grid-row>
    </sui-grid>
    <sui-divider hidden />
  </sui-container>
</template>

<script>
import ChatRoomList from "./ChatRoomList.vue";
import UserList from "./UserList.vue";
export default {
  mounted: function () {
    this.$store.dispatch("getTeams", {
      idUser: this.$store.state.userInfo.idUser
    });
  },
  computed: {
    connected() {
      return this.$store.getters.connected;
    }
  },
  watch: {
    connected: function () {
      if (!this.$store.getters.connected) {
        this.$router.push("/");
      }
    }
  },
  components: {
    ChatRoomList,
    UserList
  },
  name: "IconExample"
};
</script>

<style scoped>
#chat-history {
  height: 688px;
  overflow-y: scroll;
}
#team-lists-box {
  height: 317px;
  overflow-y: scroll;
}
#team-members-box {
  height: 398px;
  overflow-y: scroll;
}
</style>

<style>
.self .content {
  order: -1;
  text-align: right;
}
.self .icon {
  margin-left: .6em;
}
</style>
