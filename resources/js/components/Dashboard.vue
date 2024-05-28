<template>
  <v-app dark>
    <v-navigation-drawer v-model="drawer" app stateless floating width="220">
      <v-toolbar class="brown darken-3" dark>
        <v-list>
          <v-list-item @click.prevent="clickToggleDrawer">
            <v-list-item-content>
              <v-list-item-title class="title">
                <v-icon class="mr-2" data_usage>data_usage</v-icon>Vue.js CRM
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
      </v-toolbar>
      <v-list-item v-for="(title, icon) in mainMenu" :key="title" @click="handleMainMenuClick(title)">
        <v-list-item-action>
          <v-icon>{{ icon }}</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>{{ title }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-navigation-drawer>

    <v-app-bar app class="brown darken-4" dark>
      <v-app-bar-nav-icon @click.stop="clickToggleDrawer"></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
      <v-btn icon><v-icon>search</v-icon></v-btn>
      <v-btn icon><v-icon>email</v-icon></v-btn>
      <v-menu offset-y>
        <template v-slot:activator="{ on }">
          <v-btn flat small v-on="on">John Doe <v-icon>keyboard_arrow_down</v-icon></v-btn>
        </template>
        <v-list>
          <v-list-item @click="handleSettingsClick">
            <v-icon class="mr-2">settings</v-icon>
            <v-list-item-title>Settings</v-list-item-title>
          </v-list-item>
          <v-list-item @click="handleLogoutClick">
            <v-icon class="mr-2">exit_to_app</v-icon>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <v-avatar size="36" class="mr-2"><img src="http://i.pravatar.cc/150?img=53"></v-avatar>
    </v-app-bar>

    <v-main>
      <v-container class="pa-4" fluid grid-list-md>
        <v-row wrap>
          <v-col cols="12">
            <h1 class="display-1 mb-1">Dashboard</h1>
          </v-col>
          <v-col cols="12" md="6" v-for="stat in stats" :key="stat.label">
            <v-card height="100%" class="text-xs-center">
              <v-card-text class="display-1 mb-2">{{ stat.number }}</v-card-text>
              <span>{{ stat.label }}</span>
            </v-card>
          </v-col>
          <v-col cols="12" md="6">
            <v-card height="100%">
              <v-card-title class="grey darken-4">Tasks</v-card-title>
              <v-data-table :items="tasks" hide-headers hide-actions>
                <template v-slot:items="{ item }">
                  <td><v-checkbox @click="clickDeleteTask(item)"></v-checkbox></td>
                  <td>{{ item.title }}</td>
                </template>
              </v-data-table>
            </v-card>
          </v-col>
          <v-col cols="12">
            <v-card>
              <v-card-title class="grey darken-4">New Leads</v-card-title>
              <v-card-text>
                <v-text-field v-model="newLeadsSearch" append-icon="search" label="Search"></v-text-field>
              </v-card-text>
              <v-data-table :headers="newLeadsHeaders" :items="newLeads" :search="newLeadsSearch">
                <template v-slot:items="{ item }">
                  <td>{{ item.firstName }} {{ item.lastName }}</td>
                  <td>{{ item.email }}</td>
                  <td>{{ item.company }}</td>
                </template>
              </v-data-table>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import { ref } from 'vue';
import { createVuetify } from 'vuetify/framework';
import { VListItemContent } from 'vuetify/lib';
import { VAvatar, VIcon } from 'vuetify/lib';

export default {
  setup() {
    const drawer = ref(true);
    const vuetify = createVuetify();

    const mainMenu = {
      dashboard: 'Dashboard',
      people: 'Leads',
      business: 'Companies',
      business_center: 'Deals',
      file_copy: 'Invoices',
      settings: 'Settings',
    };

    const clickToggleDrawer = () => {
      drawer.value = !drawer.value;
    };

    const handleSettingsClick = () => {
      // Handle Settings Click
    };

    const handleLogoutClick = () => {
      // Handle Logout Click
    };

    const stats = [
      {
        number: '42',
        label: 'New leads this week',
      },
      {
        number: '$8,312',
        label: 'Sales this week',
      },
      {
        number: '233',
        label: 'New leads this month',
      },
      {
        number: '$24,748',
        label: 'Sales this month',
      },
    ];

    const tasks = [
      {
        id: 0,
        title: 'Book meeting for Thursday'
      },
      {
        id: 1,
        title: 'Review new leads'
      },
      {
        id: 2,
        title: 'Be awesome!'
      },
    ];

    const newLeads = [
      {
        firstName: 'Giselbert',
        lastName: 'Hartness',
        email: 'ghartness0@mail.ru',
        company: 'Kling LLC',
      },
      {
        firstName: 'Honey',
        lastName: 'Allon',
        email: 'hallon1@epa.gov',
        company: 'Rogahn-Hermann',
      },
      // ...Tambahkan entri lainnya di sini jika diperlukan
    ];

    const newLeadsSearch = ref('');

    const clickDeleteTask = (task) => {
      const i = tasks.indexOf(task);
      tasks.splice(i, 1);
    };

    const newLeadsHeaders = [
      { text: 'First Name', value: 'firstName' },
      { text: 'Last Name', value: 'lastName' },
      { text: 'Email', value: 'email' },
      { text: 'Company', value: 'company' },
    ];

    return {
      drawer,
      mainMenu,
      stats,
      tasks,
      newLeads,
      newLeadsSearch,
      clickToggleDrawer,
      clickDeleteTask,
      handleSettingsClick,
      handleLogoutClick,
      vuetify,
      newLeadsHeaders
    };
  }
};
</script>
