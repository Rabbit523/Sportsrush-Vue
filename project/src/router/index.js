import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import AboutUs from '@/components/AboutUs.vue'
import ContactUs from '@/components/ContactUs.vue'
import WhoWeAre from '@/components/WhoWeAre.vue'
import Chat from '@/components/chat/Chat.vue'
import TeamList from '@/components/teams/TeamList.vue'
import TeamCreate from '@/components/teams/TeamCreate.vue'
import TeamDetail from '@/components/teams/TeamDetail.vue'
import Profile from '@/components/profile/Profile.vue'
import Events from '@/components/events/Calendar.vue'


Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/about-us',
      name: 'About Us',
      component: AboutUs
    },
    {
      path: '/contact-us',
      name: 'Contact Us',
      component: ContactUs
    },
    {
      path: '/who-we-are',
      name: 'Who We Are',
      component: WhoWeAre
    },
    {
      path: '/chat',
      name: 'Chat',
      component: Chat,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/teamjoin',
      name: 'Teams',
      component: TeamList,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/teamcreate',
      name: 'CreateTeams',
      component: TeamCreate,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/teamdetail',
      name: 'DetailTeams',
      component: TeamDetail,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/profile',
      name: 'Profile',
      component: Profile,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/events',
      name: 'Events',
      component: Events,
      meta: {
        requiresAuth: true
      }
    }
  ]
})
