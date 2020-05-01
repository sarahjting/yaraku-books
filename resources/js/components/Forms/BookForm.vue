<template>
    <v-form v-model="valid" ref="form">
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-text-field
                        v-model="book.title"
                        :rules="validationRules.title"
                        label="Title"
                        required
                    ></v-text-field>
                </v-col>

                <v-col cols="12">
                    <v-text-field
                        v-model="book.author.name"
                        :rules="validationRules.author"
                        label="Author"
                        required
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>

<script>
export default {
    name: "BookForm",
    props: ["book"],
    data: () => ({
        valid: false,
        validationRules: {
            author: [
                v => !!v || "Author is required",
                v =>
                    (v && v.trim().split(" ").length > 1) ||
                    "Must have given and family name"
            ],
            title: [v => !!v || "Title is required"]
        }
    })
};
</script>
