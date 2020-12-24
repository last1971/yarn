import {mapGetters} from 'vuex';

export default {
    computed: {
        ...mapGetters({
            isAdmin: 'AUTH/IS_ADMIN',
            editMode: 'AUTH/EDIT-MODE',
        })
    }
}
