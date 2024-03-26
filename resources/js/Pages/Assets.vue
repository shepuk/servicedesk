<script setup>
import { ref, onMounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { usePage } from "@inertiajs/vue3";
import { router, useForm } from "@inertiajs/vue3";
import PrimaryButton from "../Components/PrimaryButton.vue";
import DialogModal from "../Components/DialogModal.vue";
import SecondaryButton from "../Components/SecondaryButton.vue";
import DangerButton from "../Components/DangerButton.vue";
import TextInput from "../Components/TextInput.vue";
import TicketKanbanBoard from "@/Components/TicketKanbanBoard.vue";
import TicketDataTable from "@/Components/TicketDataTable.vue";
import { useCookies } from "vue3-cookies";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Placeholder from "@tiptap/extension-placeholder";
import Focus from "@tiptap/extension-focus";
import Calendar from "primevue/calendar";
import FileUpload from "primevue/fileupload";

import { ChevronDown } from "lucide-vue-next";
import { Kanban } from "lucide-vue-next";
import { AlignLeft } from "lucide-vue-next";
import { ChevronRight } from "lucide-vue-next";
import { MoreVertical } from "lucide-vue-next";
import { Captions } from "lucide-vue-next";
import { Plus } from "lucide-vue-next";
import { Settings2 } from "lucide-vue-next";
import { CircleUserRound } from "lucide-vue-next";
import { BookCheck } from "lucide-vue-next";
import { TextSelect } from "lucide-vue-next";
import { KeyRound } from "lucide-vue-next";
import { PencilRuler } from "lucide-vue-next";
import { BookCopy } from "lucide-vue-next";

const assetForm = useForm({
    title: "My Asset",
    description: "Add some notes",
    // column: column.id,
    // assignee: "",
    // severity: "",
    // processing: false,
});

const assetTitleInput = ref(null);
const assetDescriptionInput = ref(null);

const calendarIcondisplay = ref();

const assetModal = ref(null);

const editor = useEditor({
    //content: "Add some notes",
    extensions: [
        StarterKit,
        Placeholder.configure({
            // Use a placeholder:
            placeholder: "Enter some notes...",
        }),
    ],
});

const openAssetModal = (ticket) => {
    //currentlyEditingAsset = ticket;
    assetModal.value = true;
};
const closeModal = () => {
    assetModal.value = false;
};

const createOrSaveAsset = () => {
    console.log("heya!");
};
</script>

<template>
    <AppLayout title="Tickets">
        <div
            class="flex flex-row items-center gap-4 -ml-[23px] pl-8 py-8 mb-4 w-full fixed backdrop-blur"
        >
            <div class="flex flex-col">
                <h1 class="text-[30px] font-bold text-zinc-800 leading-none">
                    Assets
                </h1>
            </div>
            <div
                class="flex flex-row gap-2 px-4 border shadow-sm hover:shadow-md transition-all [&>button]:p-2 [&>button]:h-full"
            >
                <button type="button" v-tooltip.bottom="'New Asset'" class="">
                    <Plus
                        color="#27272A"
                        strokeWidth="2"
                        size="18"
                        @click="openAssetModal(asset)"
                    />
                </button>
                <button type="button" v-tooltip.bottom="'Preferences'" class="">
                    <Settings2 color="#27272A" strokeWidth="2" size="18" />
                </button>
            </div>
        </div>

        <h1 class="pt-28">Content!</h1>
    </AppLayout>

    <DialogModal maxWidth="5xl" :show="assetModal" @close="closeModal">
        <template #header>
            <div class="flex justify-between flex-nowrap py-3 bg-gray-100">
                <p class="w-full text-zinc-500 font-bold text-sm py-1 px-6">
                    {{ $page.props.auth.user.name }} -> add or edit asset
                </p>
                <p
                    @click="closeModal()"
                    class="text-zinc-500 hover:text-zinc-700 cursor-pointer w-full font-bold text-sm py-1 px-6 text-end"
                >
                    close
                </p>
            </div>
        </template>
        <template #title>
            <!-- {{ "heya" }} <br />
            <span class="text-sm text-gray-600">
                Use the form below to enter new ticket information.
            </span> -->
        </template>

        <template #content>
            <form>
                <div
                    class="flex flex-col md:flex-row md:divide-x divide-dashed gap-4"
                >
                    <div
                        class="flex flex-col gap-6 md:w-2/3 p-2 pl-0 min-h-[500px]"
                    >
                        <p
                            class="text-zinc-500 font-bold flex flex-nowrap items-center gap-2"
                        >
                            <BookCheck
                                size="16"
                                color="#71717a
"
                            />
                            Basic details
                        </p>
                        <div class="w-full">
                            <input
                                required
                                ref="assetTitleInput"
                                v-model="assetForm.title"
                                type="text"
                                class="w-[98%] border-0 border-zinc-200 border-b border-solid p-2 text-3xl rounded-none focus-visible:border-emerald-400"
                                placeholder=""
                                value=""
                                name="assettitle"
                            />
                        </div>
                        <editor-content
                            :editor="editor"
                            ref="assetDescriptionInput"
                            v-model="assetForm.description"
                            type="text"
                            class="tiptap-editor-container border-0 border-zinc-200 border-b border-solid p-2 w-full rounded-none"
                            placeholder="Enter a description or notes here."
                            value=""
                            rows="1"
                            name="assetdescription"
                            data-placeholder="Enter a description or notes here."
                        />
                        <div class="tiptap-buttons" v-if="editor">
                            <button
                                type="button"
                                @click="
                                    editor.chain().focus().toggleBold().run()
                                "
                                :disabled="
                                    !editor
                                        .can()
                                        .chain()
                                        .focus()
                                        .toggleBold()
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('bold'),
                                }"
                            >
                                bold
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor.chain().focus().toggleItalic().run()
                                "
                                :disabled="
                                    !editor
                                        .can()
                                        .chain()
                                        .focus()
                                        .toggleItalic()
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('italic'),
                                }"
                            >
                                italic
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor.chain().focus().toggleStrike().run()
                                "
                                :disabled="
                                    !editor
                                        .can()
                                        .chain()
                                        .focus()
                                        .toggleStrike()
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('strike'),
                                }"
                            >
                                strikethrough
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor.chain().focus().toggleCode().run()
                                "
                                :disabled="
                                    !editor
                                        .can()
                                        .chain()
                                        .focus()
                                        .toggleCode()
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('code'),
                                }"
                            >
                                code
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor.chain().focus().unsetAllMarks().run()
                                "
                            >
                                clear styles
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor.chain().focus().setParagraph().run()
                                "
                                :class="{
                                    'is-active': editor.isActive('paragraph'),
                                }"
                            >
                                paragraph
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleHeading({ level: 1 })
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('heading', {
                                        level: 1,
                                    }),
                                }"
                            >
                                h1
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleHeading({ level: 2 })
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('heading', {
                                        level: 2,
                                    }),
                                }"
                            >
                                h2
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleHeading({ level: 3 })
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('heading', {
                                        level: 3,
                                    }),
                                }"
                            >
                                h3
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleHeading({ level: 4 })
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('heading', {
                                        level: 4,
                                    }),
                                }"
                            >
                                h4
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleHeading({ level: 5 })
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('heading', {
                                        level: 5,
                                    }),
                                }"
                            >
                                h5
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleHeading({ level: 6 })
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('heading', {
                                        level: 6,
                                    }),
                                }"
                            >
                                h6
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleBulletList()
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('bulletList'),
                                }"
                            >
                                bullet list
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleOrderedList()
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('orderedList'),
                                }"
                            >
                                ordered list
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleCodeBlock()
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('codeBlock'),
                                }"
                            >
                                code block
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .toggleBlockquote()
                                        .run()
                                "
                                :class="{
                                    'is-active': editor.isActive('blockquote'),
                                }"
                            >
                                blockquote
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor
                                        .chain()
                                        .focus()
                                        .setHorizontalRule()
                                        .run()
                                "
                            >
                                horizontal rule
                            </button>
                            <button
                                type="button"
                                @click="
                                    editor.chain().focus().setHardBreak().run()
                                "
                            >
                                hard break
                            </button>
                            <button
                                type="button"
                                @click="editor.chain().focus().undo().run()"
                                :disabled="
                                    !editor.can().chain().focus().undo().run()
                                "
                            >
                                undo
                            </button>
                            <button
                                type="button"
                                @click="editor.chain().focus().redo().run()"
                                :disabled="
                                    !editor.can().chain().focus().redo().run()
                                "
                            >
                                redo
                            </button>
                        </div>

                        <p
                            class="mt-4 text-zinc-500 mb-[0px] font-bold flex flex-nowrap items-center gap-2"
                        >
                            <BookCopy
                                size="16"
                                color="#71717a

"
                            />
                            Further details
                        </p>
                        <input
                            required
                            ref="assetSerialInput"
                            v-model="assetForm.serial"
                            type="text"
                            class="border-0 border-zinc-200 border-b border-solid p-2 w-[90%]] rounded-none focus-visible:border-emerald-400"
                            placeholder="Add a serial number or licence key"
                            value=""
                            name="assetserial"
                        />

                        <input
                            required
                            ref="assetLocationInput"
                            v-model="assetForm.location"
                            type="text"
                            class="border-0 border-zinc-200 border-b border-solid p-2 w-[90%]] rounded-none focus-visible:border-emerald-400"
                            placeholder="Add location details"
                            value=""
                            name="assetlocation"
                        />

                        <div class="w-full flex flex-row flex-nowrap gap-4">
                        <Calendar
                            v-model="calendarIcondisplay"
                            placeholder="Select a renewal date"
                            showIcon
                            iconDisplay="input"
                            inputId="icondisplay"
                            class="p-2 w-1/2 border-0 border-zinc-200 border-b border-solid focus-visible:border-emerald-500"
                        />
                        <select
                                name="cars"
                                id="cars"
                                class="w-1/2 py-2 border border-b-1 border-t-0 border-l-0 border-r-0 border-solid border-zinc-200 focus-visible:border-emerald-500 focus-visible:outline-none"
                            >
                                <option disabled selected value="volvo">
                                    Expiry type
                                </option>
                                <option value="saab">Warranty</option>
                                <option value="mercedes">Licence</option>
                                <option value="mercedes">Membership</option>
                            </select>
                    </div>

                        <p
                            class="text-zinc-500 font-bold flex flex-nowrap items-center gap-2 mt-10"
                        >
                            <PencilRuler
                                size="16"
                                color="#71717a
"
                            />
                            Custom Fields
                        </p>
                        <p v-if="!customFields" class="mb-20 text-center">
                        No custom fields. Go to preferences to add some.
                        </p>
                        <!-- <textarea
                            required
                            ref="assetDesriptionInput"
                            v-model="assetForm.description"
                            type="text"
                            class="border-0 border-zinc-200 border-b border-solid p-2 w-full rounded-none focus-visible:border-emerald-400"
                            placeholder="Enter a description or notes here."
                            value=""
                            rows="1"
                            name="assetdescription"
                        /> -->
                    </div>
                    <div
                        class="md:w-1/3 md:py-2 md:pl-4 min-h-40 flex flex-col justify-between"
                    >
                        <div>
                            <p
                                class="text-zinc-500 mb-[16px] font-bold flex flex-nowrap items-center gap-2"
                            >
                                <TextSelect
                                    size="16"
                                    color="#71717a

"
                                />
                                Type
                            </p>
                            <select
                                name="cars"
                                id="cars"
                                class="mb-16 w-full my-4 py-2 border border-b-1 border-t-0 border-l-0 border-r-0 border-solid border-zinc-200 focus-visible:border-emerald-500 focus-visible:outline-none"
                            >
                                <option disabled selected value="volvo">
                                    Select a type
                                </option>
                                <option value="saab">Saab</option>
                                <option value="mercedes">Mercedes</option>
                                <option value="audi">Audi</option>
                            </select>
                            <p
                                class="text-zinc-500 mb-[16px] font-bold flex flex-nowrap items-center gap-2"
                            >
                                <CircleUserRound
                                    size="16"
                                    color="#71717a

"
                                />
                                Customer info
                            </p>

                            <select
                                name="cars"
                                id="cars"
                                class="w-full my-4 py-2 border border-b-1 border-t-0 border-l-0 border-r-0 border-solid border-zinc-200 focus-visible:border-emerald-500 focus-visible:outline-none"
                            >
                                <option disabled selected value="volvo">
                                    Select a customer
                                </option>
                                <option value="saab">Saab</option>
                                <option value="mercedes">Mercedes</option>
                                <option value="audi">Audi</option>
                            </select>

                            <select
                                name="cars"
                                id="cars"
                                class="w-full my-4 py-2 border border-b-1 border-t-0 border-l-0 border-r-0 border-solid border-zinc-200 focus-visible:border-emerald-500 focus-visible:outline-none"
                            >
                                <option disabled selected value="volvo">
                                    Select a user
                                </option>
                                <option value="saab">Saab</option>
                                <option value="mercedes">Mercedes</option>
                                <option value="audi">Audi</option>
                            </select>
                        </div>
                        <div
                            class="w-full bg-stone-200 px-2 py-1 [&>div>p]:text-stone-600 font-bold [&>div>p]:text-sm divide-y divide-solid divide-stone-300"
                        >
                            <div class="flex flex-row justify-between mb-1">
                                <p>Created</p>
                                <p>
                                    {{ assetForm.created_at || "Jan 1 1970, Paul S" }}
                                </p>
                            </div>

                            <div class="flex flex-row justify-between pt-1">
                                <p>Updated</p>
                                <p>
                                    {{ assetForm.updated_at || "Not yet updated" }}
                                </p>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </form>
        </template>

        <template #footer>
            <div class="w-full flex flex-row justify-between">
                <div>
                    <DangerButton @click="deleteTicket(currentlyEditingTicket)">
                        Delete Asset
                    </DangerButton>
                </div>
                <div>
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton
                        class="ms-3"
                        :class="{ 'opacity-25': assetForm.processing }"
                        :disabled="assetForm.processing"
                        @click="createOrSaveAsset()"
                    >
                        Save Asset
                    </PrimaryButton>
                </div>
            </div>
        </template>
    </DialogModal>
</template>
