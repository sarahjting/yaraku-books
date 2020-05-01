<template>
    <v-dialog v-model="dialog" max-width="290">
        <template v-slot:activator="{ on }">
            <v-icon small v-on="on">
                mdi-delete
            </v-icon>
        </template>
        <v-card>
            <v-card-title class="headline">Delete Book</v-card-title>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog = false"
                    >Cancel</v-btn
                >
                <v-btn color="red darken-1" dark @click="submitForm"
                    >Delete</v-btn
                >
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    name: "DeleteBookButton",
    props: ["book"],
    data: () => ({
        dialog: false
    }),
    methods: {
        submitForm: function() {
            this.$store.dispatch("deleteBook", this.book.id);
            this.dialog = false;
        }
    }
};
</script>
