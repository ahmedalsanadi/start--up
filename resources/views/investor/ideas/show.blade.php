<!--resources/views/investor/ideas/show.blade.php-->
<!-- show detailed idea info related to specific announcement with appility to manage stages-->


<!-- resources/views/investor/ideas/show.blade.php -->
<x-layout title="تفاصيل الفكرة">
    <div class="space-y-6">
        <!-- Idea Header -->
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">بيانات الفكرة</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    تم النشر في {{ $idea->created_at->format('Y/m/d') }}
                </p>
            </div>
        </div>

        @if ($idea->idea_type === 'creative')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!--right side ----->
                    <x-card-gradient-bg :withGradient="false">
                        <!-- Idea Stages Timeline -->
                        <div class=" max-w-2xl mx-auto">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-right">مراحل تقييم الفكرة</h2>

                            <div class="relative">
                                <!-- Vertical Line -->
                                <div class="absolute h-full w-0.5 bg-gray-200 dark:bg-gray-700 right-4"></div>

                                <div class="space-y-12">
                                    @php
                                        $allStages = ['new', 'initial_acceptance', 'under_review', 'expert_consultation', 'final_decision'];
                                        $currentStageIndex = array_search($idea->stage, $allStages);
                                    @endphp

                                    @foreach($allStages as $index => $stageName)
                                                            @php
                                                                $stage = $idea->stages->where('stage', $stageName)->first();
                                                                $isCompleted = $stage && $stage->stage_status;
                                                                $isCurrent = $idea->stage === $stageName;
                                                                $isPending = $index > $currentStageIndex;
                                                            @endphp

                                                            <div class="relative flex items-start group">
                                                                <!-- Stage Indicator -->
                                                                <div
                                                                    class="absolute right-0 flex items-center justify-center h-8 w-8 rounded-full border-2
                                                                                                                                                                                                                                                                                                                            {{ $isCompleted ? 'bg-lime-500 border-lime-500' : ($isCurrent ? 'bg-blue-500 border-blue-500' : 'bg-gray-100 border-gray-300') }}
                                                                                                                                                                                                                                                                                                                            dark:border-opacity-50 z-10">
                                                                    @if($isCompleted)
                                                                        <i data-lucide="check" class="w-4 h-4 text-white"></i>
                                                                    @elseif($isCurrent)
                                                                        <i data-lucide="loader" class="w-4 h-4 text-white animate-spin"></i>
                                                                    @else
                                                                        <i data-lucide="circle" class="w-4 h-4 text-gray-400"></i>
                                                                    @endif
                                                                </div>

                                                                <!-- Stage Content -->
                                                                <div class="mr-12 flex-1">
                                                                    <div
                                                                        class="bg-gray-50 dark:bg-gray-700/50   rounded-lg p-4
                                                                                                                                                                                                                                                                                                                                {{ $isCompleted ? 'border-l-4 border-green-500' : ($isCurrent ? 'border-l-4 border-blue-500' : '') }}">

                                                                        <div class="flex items-center justify-between mb-2">
                                                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                                                {{ __("ideas.stages.$stageName") }}
                                                                            </h3>

                                                                        </div>

                                                                        <div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
                                                                            @if($stage)
                                                                                <div class="flex items-center gap-2">
                                                                                    <i data-lucide="calendar" class="w-4 h-4"></i>
                                                                                    <span>{{ $stage->changed_at ? $stage->changed_at->format('Y/m/d H:i') : 'لم يتم التحديث بعد' }}</span>
                                                                                </div>
                                                                            @else
                                                                                <span class="text-gray-400">في انتظار الوصول لهذه المرحلة</span>
                                                                            @endif
                                                                        </div>

                                                                        @if($isCurrent && $idea->status !== 'approved')
                                                                            <div class="flex items-center gap-2 mt-1">
                                                                                <!-- Approve Button -->

                                                                                <button onclick="openApproveIdeaModal()"
                                                                                    class="p-2 rounded-lg bg-lime-500 hover:bg-lime-600">
                                                                                    <i data-lucide="check-circle" class="w-6 h-6 text-white "></i>
                                                                                </button>

                                                                                <!-- Reject Button -->
                                                                                <button onclick="openRejectIdeaModal()"
                                                                                    class="p-2 rounded-lg bg-red-700 hover:bg-red-800 ">
                                                                                    <i data-lucide="x-circle" class="w-6 h-6 text-white"></i>
                                                                                </button>
                                                                            </div>
                                                                        @endif

                                                                    </div>
                                                                </div>
                                                            </div>
                                    @endforeach
                                </div>
                            </div>



                        </div>




                    </x-card-gradient-bg>

                    <!--left side -->
                    <div class="lg:col-span-2">
                        <x-card-gradient-bg>
                            <!-- Decorative Background Element -->
                            <div
                                class="absolute top-0 right-0 w-64 h-64 bg-blue-50 dark:bg-blue-900/20 rounded-full -translate-y-32 translate-x-32 blur-3xl">
                            </div>

                            <!-- Idea Details Card -->
                            <div class="relative space-y-8">
                                <!-- Header Section: Entrepreneur Profile and Status -->
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <!-- Entrepreneur Info -->
                                    <div class="flex items-center gap-4">
                                        <x-profile-img src="{{ $idea->entrepreneur->profile_image }}" alt="صورة رائد الأعمال" />
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $idea->entrepreneur->name }}
                                            </h3>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                رائد أعمال
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Status and Time -->
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center gap-2">
                                            <i data-lucide="clock" class="w-5 h-5 text-gray-500 dark:text-gray-400"></i>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $idea->created_at->diffForHumans() }}
                                            </span>
                                        </div>

                                        <!-- Status Badge -->

                                        @if($idea->status == 'in-progress')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium
                                                                                                                 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400
                                                                                                                 border border-amber-200 dark:border-amber-800
                                                                                                                ">

                                                جاري
                                            </span>
                                        @endif

                                        @if($idea->status == 'approved')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium
                                                                                                                 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400
                                                                                                                 border border-green-200 dark:border-green-800">

                                                تمت الموافقة
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Main Content Section -->
                                <div class="space-y-6">
                                    <!-- Title and Description -->
                                    <div class="bg-white/50 dark:bg-gray-800/50 rounded-lg p-6">
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $idea->name }}</h3>
                                        <p class="text-gray-700 dark:text-gray-300 text-base leading-relaxed mb-4">
                                            {{ $idea->brief_description }}
                                        </p>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                                            {{ $idea->detailed_description }}
                                        </p>
                                    </div>

                                    <!-- Idea Image -->
                                    <div class="aspect-w-16 aspect-h-9 rounded-xl overflow-hidden">
                                        <img src="{{ $idea->image
                ? (filter_var($idea->image, FILTER_VALIDATE_URL)
                    ? $idea->image
                    : asset('storage/' . $idea->image))
                : 'https://placehold.co/800x400/e2e8f0/1e293b?text=No+Image+Available' }}" alt="صورة الفكرة"
                                            class="w-full h-full object-cover">
                                    </div>

                                    <!-- Key Details Grid -->
                                    <x-key-details-grid :idea="$idea" />

                                    <!-- Feasibility Study -->
                                    <x-feasibility-study :feasibilityStudy="$idea->feasibility_study" />


                                    <!-- Categories Section -->
                                    <x-categories-section :categories="$idea->categories" />
                                </div>
                            </div>
                        </x-card-gradient-bg>
                    </div>
                </div>
        @else
            <x-traditional-idea :idea="$idea" />
        @endif


    </div>



    <!-- Reject Idea Modal -->
    <div id="rejectIdeaModal" class="fixed inset-0 bg-black/30 dark:bg-black/50 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Modal Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-xl p-8 border border-indigo-100 dark:border-indigo-900/50">
                <!-- Header -->
                <div class="flex justify-between items-start mb-6 border-b border-gray-100 dark:border-gray-700 pb-4">
                    <button type="button" onclick="closeRejectIdeaModal()"
                        class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">رفض الفكرة</h3>
                </div>

                <form action="{{ route('investor.ideas.reject-idea', $idea) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <!-- Warning Message Box -->
                    <div
                        class="bg-red-50 dark:bg-gray-900/50 rounded-xl p-6 border border-red-100 dark:border-red-900/50">
                        <div class="flex gap-4 items-start">
                            <!-- Warning Icon -->
                            <div class="rounded-full bg-red-100 dark:bg-red-900/50 p-3 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-500"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>

                            <!-- Warning Text -->
                            <div class="flex-1 text-right">
                                <h4 class="text-lg font-semibold text-red-800 dark:text-red-500 mb-2">
                                    هل أنت متأكد من رفض هذه الفكرة؟
                                </h4>
                                <p class="text-sm text-red-700 dark:text-red-400">
                                    تحذير: لن تتمكن من رؤية هذه الفكرة مرة أخرى.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information (Optional) -->
                    <div
                        class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
                        <div class="flex gap-4 items-start">
                            <!-- Info Icon -->
                            <div class="rounded-full bg-indigo-100 dark:bg-indigo-900/50 p-3 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                            <!-- Info Text -->
                            <div class="flex-1 text-right">
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    عند رفض الفكرة، سيتم إخطار صاحب الفكرة وإزالتها من قائمة الأفكار المعروضة عليك.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4 pt-4 mt-6 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" onclick="closeRejectIdeaModal()"
                            class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            إلغاء
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-700 rounded-lg transition-colors duration-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                            تأكيد الرفض
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Approve Idea Modal -->
    <div id="approveIdeaModal"
        class="fixed inset-0 bg-black/30 dark:bg-black/50 backdrop-blur-sm hidden z-50 transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Modal Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-xl transform transition-all duration-300 scale-95 opacity-0"
                id="modalContent">
                <!-- Header -->
                <div class="relative overflow-hidden">
                    <!-- Celebration Background (Only for final_decision) -->
                    @if($idea->stage === 'final_decision')
                        <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 opacity-10"></div>
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-green-500/10 rounded-full blur-2xl"></div>
                        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-blue-500/10 rounded-full blur-2xl"></div>
                    @endif

                    <div class="flex justify-between items-start p-6 relative">
                        <button type="button" onclick="closeApproveIdeaModal()" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400
                                   transition-colors p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                            @if($idea->stage === 'final_decision')
                                الموافقة النهائية
                            @else
                                موافقة على المرحلة
                            @endif
                        </h3>
                    </div>
                </div>

                <form action="{{ route('investor.ideas.approve-idea', $idea) }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PATCH')

                    @if($idea->stage === 'final_decision')
                        <!-- Final Decision Celebration Message -->
                        <div class="text-center space-y-4">
                            <!-- Animated Success Icon -->
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30
                                                                                                            rounded-full mb-4 animate-bounce">
                                <i data-lucide="party-popper" class="w-10 h-10 text-lime-600 dark:text-lime-400"></i>
                            </div>

                            <h4 class="text-2xl font-bold text-lime-500">
                                تهانينا! 🎉
                            </h4>

                            <div class="space-y-3 max-w-md mx-auto">
                                <p class="text-gray-700 dark:text-gray-300">
                                    أنت على وشك الموافقة النهائية على هذه الفكرة الرائعة!
                                </p>
                                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-xl">
                                    <p class="text-green-700 dark:text-green-400 text-sm">
                                        سيتم التواصل معك قريباً من قبل فريق الإدارة لإتمام الإجراءات النهائية وتوقيع العقود
                                        اللازمة.
                                    </p>
                                </div>
                            </div>

                            <!-- Progress Steps -->
                            <div class="flex justify-center items-center gap-2 mt-6">
                                <span class="w-3 h-3 bg-lime-500 rounded-full"></span>
                                <div class="w-16 h-1 bg-lime-500"></div>
                                <span class="w-3 h-3 bg-lime-500 rounded-full"></span>
                                <div class="w-16 h-1 bg-lime-500"></div>
                                <span class="w-3 h-3 bg-lime-500 rounded-full"></span>
                            </div>
                        </div>
                    @else
                        <!-- Regular Stage Approval Message -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center">
                                        <i data-lucide="arrow-up-circle"
                                            class="w-6 h-6 text-lime-600 dark:text-lime-400"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-blue-800 dark:text-blue-400">
                                        انتقال إلى المرحلة التالية
                                    </h4>
                                    <p class="text-sm text-blue-600 dark:text-blue-300 mt-1">
                                        الموافقة ستنقل الفكرة إلى المرحلة التالية من التقييم
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" onclick="closeApproveIdeaModal()" class="px-6 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300
                                   hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                            إلغاء
                        </button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white
                                   @if($idea->stage === 'final_decision')
                                       bg-green-600 hover:bg-green-700 dark:bg-green-600 dark:hover:bg-green-700
                                   @else
                                       bg-blue-600 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700
                                   @endif
                                   rounded-lg transition-colors duration-200
                                   focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800
                                   flex items-center gap-2">
                            <i data-lucide="{{ $idea->stage === 'final_decision' ? 'check-circle-2' : 'arrow-right-circle' }}"
                                class="w-4 h-4"></i>
                            {{ $idea->stage === 'final_decision' ? 'تأكيد الموافقة النهائية' : 'موافقة والانتقال للمرحلة التالية' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- JavaScript to Handle Modal -->

    <script>
        function openRejectIdeaModal() {
            document.getElementById('rejectIdeaModal').classList.remove('hidden');
        }

        function closeRejectIdeaModal() {
            document.getElementById('rejectIdeaModal').classList.add('hidden');
        }


    </script>
    <script>
        function openApproveIdeaModal() {
            const modal = document.getElementById('approveIdeaModal');

            const content = document.getElementById('modalContent');
            modal.classList.remove('hidden');
            // Add small delay for animation
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 50);
        }

        function closeApproveIdeaModal() {
            const modal = document.getElementById('approveIdeaModal');
            const content = document.getElementById('modalContent');
            content.classList.add('scale-95', 'opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Close modal when clicking outside
        document.getElementById('approveIdeaModal').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                closeApproveIdeaModal();
            }
        });

        // Close modal on Escape key press
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeApproveIdeaModal();
            }
        });
    </script>




</x-layout>
