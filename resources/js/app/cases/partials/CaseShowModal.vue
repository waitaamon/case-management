<template>
    <div>
        <Modal
            v-model="showModal"
            modalClass="max-width: 1000px"
            title="Legal Case Details"
        >
            <div class="py-3 overflow-auto" v-if="legalCase">
                <table class="min-w-full max-w-4xl divide-y divide-gray-200">
                    <tbody class="bg-white divide-y divide-gray-200">

                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Title
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ legalCase.title }}
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Public Sector
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ legalCase.public_sector_name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            investigator
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ legalCase.investigator_name }}
                        </td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Status
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                            {{ legalCase.status }}
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Description
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 break-all">
                            {{ legalCase.description }}
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            System Events
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="space-y-2 w-full">
                                <div v-for="log in legalCase.system_events"
                                     class="bg-gray-100 w-full p-2 flex items-center space-x-2">
                                    <input type="checkbox" class="block" v-model="selected" :value="log.id"
                                           v-if="!legalCase.is_published">
                                    <div class="">
                                        <p>{{ log.user }}</p>
                                        <p>{{ log.host_ip }}</p>
                                        <p>{{ log.created_at }}</p>
                                        <p class="break-all">{{ log.message }} </p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex justify-end" v-if="$user.role === 'agency-admin' && !legalCase.is_published">
                    <button
                        @click.prevent="publishCase"
                        class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        type="button"
                    >Publish
                    </button>
                </div>

                <div
                    v-if="judiciaryOfficers && $user.role === 'judiciary-admin' && !legalCase.judicial_officer_name"
                    class="bg-green-100 p-4 rounded-lg">
                    <div class="grid grid-cols-5 gap-4">
                        <div class="col-span-4">
                            <label for="judicial_officer" class="block text-sm font-medium text-gray-700">Judicial
                                officer</label>
                            <div class="mt-1">
                                <multiselect
                                    v-model="judicial_officer"
                                    :options="judiciaryOfficers"
                                    id="judicial_officer"
                                    trackBy="id"
                                    label="name"
                                    name="judicial_officer"
                                    placeholder="select judicial officer"
                                ></multiselect>
                            </div>
                            <p v-if="errors.judicial_officer" class="mt-2 text-sm text-red-600"
                               id="judicial_officer-error">
                                {{ errors.judicial_officer[0] }}
                            </p>
                        </div>
                        <div class="col-span-1 pt-6">
                            <button
                                @click.prevent="assignOfficer"
                                class="inline-flex items-center px-6 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                type="button"
                            >save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script>
export default {
    name: 'case-show-modal',
    props: {
        judiciaryOfficers: {
            required: false,
            type: Array
        }
    },

    data() {
        return {
            showModal: false,
            legalCase: null,
            errors: [],
            selected: [],
            judicial_officer: ''
        }
    },
    methods: {
        async publishCase() {
            try {
                if (this.selected.length < 1) {
                    alert(' You have not selected system event.')
                    return;
                }

                await axios.post('api/publish-cases', {
                    id: this.legalCase.id,
                    selected: this.selected
                })

                this.$emit('fetch-cases', true)

                this.$toasted.success('Successfully published legal case.')

                this.showModal = false

            } catch (e) {
                this.$toasted.error('Failed to published legal case.')
            }
        },

        async assignOfficer() {
            try {
                if (this.assignOfficer === '') {
                    alert(' You have not selected judicial officer.')
                    return;
                }

                await axios.post('api/assign-judicial-officer', {
                    id: this.legalCase.id,
                    officer: this.judicial_officer.id
                })

                this.$emit('fetch-cases', true)

                this.$toasted.success('Successfully assigned officer to legal case.')

                this.showModal = false

            } catch (e) {
                this.$toasted.error('Failed to assigned officer to legal case.')
            }
        }
    }
}
</script>