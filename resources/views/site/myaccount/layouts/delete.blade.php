<div class="fixed hidden items-center inset-0 bg-black bg-opacity-50 overflow-y-auto z-99999 delete-modal">
    <div class="relative sm:mx-auto mx-4 md:px-6 px-3 py-5 w-max rounded-xl bg-white modal-h modal-box-shadow transition-all ease-in-out"
        id="modal-main">
        <div class="relative z-50">
            <svg class="lg:block hidden ltr:ml-auto rtl:mr-auto cursor-pointer text-black close-btn"
                xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13"
                fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M0.455612 0.455612C1.06309 -0.151871 2.04802 -0.151871 2.6555 0.455612L11.9888 9.78895C12.5963 10.3964 12.5963 11.3814 11.9888 11.9888C11.3814 12.5963 10.3964 12.5963 9.78895 11.9888L0.455612 2.6555C-0.151871 2.04802 -0.151871 1.06309 0.455612 0.455612Z"
                    fill="currentColor"></path>
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.9887 0.455612C11.3812 -0.151871 10.3963 -0.151871 9.78884 0.455612L0.455503 9.78895C-0.151979 10.3964 -0.151979 11.3814 0.455503 11.9888C1.06298 12.5963 2.04791 12.5963 2.65539 11.9888L11.9887 2.6555C12.5962 2.04802 12.5962 1.06309 11.9887 0.455612Z"
                    fill="currentColor"></path>
            </svg>
            <form method="post">
                @csrf
                @method('delete')
                <div class="flex gap-4">
                    <span class="w-max h-full">
                        <svg class="w-10 h-10 p-2 bg-red-100 rounded-full flex items-center justify-center"
                            xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                            fill="none">
                            <circle cx="16" cy="16" r="16" fill="#F9E8E8"></circle>
                            <path
                                d="M17.7925 8L17.5367 18.9463H15.3411L15.0746 8H17.7925ZM15 22.3037C15 21.9129 15.1279 21.586 15.3837 21.3231C15.6466 21.0531 16.009 20.9181 16.4709 20.9181C16.9256 20.9181 17.2845 21.0531 17.5474 21.3231C17.8103 21.586 17.9417 21.9129 17.9417 22.3037C17.9417 22.6803 17.8103 23.0036 17.5474 23.2736C17.2845 23.5365 16.9256 23.668 16.4709 23.668C16.009 23.668 15.6466 23.5365 15.3837 23.2736C15.1279 23.0036 15 22.6803 15 22.3037Z"
                                fill="#C8191C"></path>
                        </svg>
                    </span>
                    <div>
                        <span
                            class="mt-4 leading-4 mb-2.5 font-medium text-lg text-black ltr:ml-2 rtl:mr-2 ltr:text-left rtl:text-right">{{ __('Are you sure you want to delete this?') }}</span>
                        <p class="text-gray-700 font-medium text-sm ltr:ml-2 rtl:mr-2 ltr:text-left rtl:text-right pr-5 mt-2">
                            {{ __(' Please keep in mind that once deleted, you can not undo it.') }} </p>
                    </div>
                </div>
                <div class="flex justify-end mt-8 mb-0 md:gap-7 gap-4">
                    <button type="button"
                        class="items-center  rounded px-8 cursor-pointer font-medium text-sm text-black w-max h-10 bg-white border border-gray-700 close-btn">{{ __('Cancel') }}
                    </button>
                    <button type="submit"
                        class="items-center cursor-pointer px-6 font-medium text-sm text-white bg-black hover:bg-yellow-500 hover:text-black w-max h-10 rounded">{{ __('Yes, Delete') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
