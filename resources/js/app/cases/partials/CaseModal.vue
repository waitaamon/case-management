<template>
    <div>

        <button
            type="button"
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            @click="showModal=true"
        >
            New Case
        </button>

        <Modal v-model="showModal" modalClass="max-width: 700px" title="New Legal Case">
            <div class="py-3">
                <form class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <div class="mt-1">
                            <input v-model="form.title" type="text" name="title" id="title"
                                   class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                   :class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : errors.title}"
                                   placeholder="Title">
                        </div>
                        <p v-if="errors.title" class="mt-2 text-sm text-red-600" id="title-error">
                            {{ errors.title[0] }}
                        </p>
                    </div>
                    <div>
                        <label for="public_sector" class="block text-sm font-medium text-gray-700">Public sector institution</label>
                        <div class="mt-1">
                            <multiselect
                                v-model="form.public_sector"
                                :options="publicSectors"
                                id="public_sector"
                                trackBy="id"
                                label="name"
                                name="public_sector"
                                placeholder="select public sector institution"
                            ></multiselect>
                        </div>
                        <p v-if="errors.public_sector" class="mt-2 text-sm text-red-600" id="public_sector-error">
                            {{ errors.public_sector[0] }}
                        </p>
                    </div>

                    <div v-if="$user.role === 'agency-admin'">
                        <label for="building" class="block text-sm font-medium text-gray-700">Investigator</label>
                        <div class="mt-1">
                            <multiselect
                                v-model="form.investigator"
                                :options="investigators"
                                id="building"
                                trackBy="id"
                                label="name"
                                name="investigator"
                                placeholder="select investigator"
                            ></multiselect>
                        </div>
                        <p v-if="errors.investigator" class="mt-2 text-sm text-red-600" id="investigator-error">
                            {{ errors.investigator[0] }}
                        </p>
                    </div>

<!--                    <div>-->
<!--                        <label for="status" class="block text-sm font-medium text-gray-700">Case Status</label>-->
<!--                        <div class="mt-1">-->
<!--                            <multiselect-->
<!--                                v-model="form.status"-->
<!--                                :options="['active', 'terminated', 'complete']"-->
<!--                                id="status"-->
<!--                                name="status"-->
<!--                                placeholder="select case status"-->
<!--                            ></multiselect>-->
<!--                        </div>-->
<!--                        <p v-if="errors.status" class="mt-2 text-sm text-red-600" id="status-error">-->
<!--                            {{ errors.status[0] }}-->
<!--                        </p>-->
<!--                    </div>-->

                    <div v-if="$user.role === 'agency-admin'">
                        <label for="status" class="block text-sm font-medium text-gray-700">Published</label>
                        <div class="mt-1">
                            <multiselect
                                v-model="form.published"
                                :options="[{name: 'Published', value: true}, {name: 'Not Published', value: false}, ]"
                                id="published"
                                name="status"
                                track-by="value"
                                label="name"
                                placeholder="Published"
                            ></multiselect>
                        </div>
                        <p v-if="errors.published" class="mt-2 text-sm text-red-600" id="published-error">
                            {{ errors.published[0] }}
                        </p>
                    </div>

                    <div>
                        <label for="note" class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1">
                            <textarea v-model="form.description" name="description" id="note"
                                      class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                      :class="{'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : errors.description}"
                            ></textarea>
                        </div>
                        <p v-if="errors.description" class="mt-2 text-sm text-red-600" id="description-error">
                            {{ errors.description[0] }}
                        </p>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click="saveAndNew"
                        >
                            Save and New
                        </button>
                        <button
                            type="button"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            @click.prevent="submit"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </Modal>
    </div>
</template>

<script>
export default {
    name: 'case-modal',
    props: ['investigators', 'publicSectors'],
    data() {
        return {
            showModal: false,
            closeAfterSave: true,
            errors: {},
            form: {}
        }
    },
    methods: {
        submit() {
            this.errors = {}
            axios.post('/api/legal-cases', {
                ...this.form,
                public_sector: typeof this.form.public_sector === 'object' ?  this.form.public_sector.id : this.form.public_sector,
                investigator: typeof this.form.investigator === 'object' ?  this.form.investigator.id : this.form.investigator,
                published: typeof this.form.published === 'object' ?  this.form.published.value : this.form.published,
            })
                .then(response => {
                    this.resetForm()

                    this.$emit('fetch-cases', true)

                    this.$toasted.success('Successfully saved case.');

                    this.showModal = !this.closeAfterSave

                    this.closeAfterSave = true
                }).catch(e => {
                if (e.response.status === 422) {
                    this.errors = e.response.data.errors
                    this.$toasted.error('The form submitted has errors');
                    return
                }
                this.$toasted.error('Something went wrong try again later');
            })
        },
        saveAndNew() {
            this.closeAfterSave = false
            this.submit()
        },
        resetForm() {
            this.form = {
                title: '',
                description: '',
                public_sector: '',
                investigator: '',
                status: 'active',
                published: false,
            }
        }
    },
    created() {
        this.resetForm()
    }
}
</script>