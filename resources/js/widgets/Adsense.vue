<template>
    <div :id="aid">

    </div>
</template>

<script>
export default {
    props: {
        adSlot: {
            type: String,
            required: true
        },
        adFormat: {
            type: String,
            required: false,
            default: 'auto'
        },
        adStyle: {
            type: String,
            required: false,
            default: 'display: block'
        },
    },
    data() {
        return {
            timer: '',
            value: 0,
            aid: ''
        };
    },
    created() {
        this.aid = 'as_' + this.adSlot;
    },
    mounted() {
        if (!this.$store.getters.isVip) {
            this.setAdsense();
            this.timer = setInterval(this.refreshAdsense, 300000);
        }
    },
    computed: {
        adClient() {
            return this.$store.getters.adsense_client;
        },
    },
    methods: {
        refreshAdsense() {
            if (this.value < 999) {
                this.value++;
                this.setAdsense();
            }
        },
        setAdsense() {
            document.getElementById(this.aid).innerHTML = '<ins class="adsbygoogle" style="display:block" data-ad-client="' + this.adClient + '" data-ad-slot="' + this.adSlot + '" data-ad-format="auto"  data-full-width-responsive="true"></ins>';
            (window.adsbygoogle = window.adsbygoogle || []).push({})
        }
    },
    beforeDestroy() {
        if (!this.$store.getters.isVip) {
            clearInterval(this.timer);
        }
    }
}
</script>
