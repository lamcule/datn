export default {
  methods: {
    changeLocale (locale) {
      this.$i18n.locale = locale
      localStorage.setItem('locale', locale)
    }
  },
  created: function () {
    var locale = localStorage.getItem('locale')
    if (locale && this.$i18n) {
      this.$i18n.locale = locale
    }
  }
}
