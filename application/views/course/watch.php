<div class="min-h-screen bg-gray-900 flex">
    <!-- Sidebar -->
    <div class="w-80 bg-gray-800 h-screen overflow-y-auto fixed left-0 top-0">
        <div class="p-4">
            <h2 class="text-xl font-bold text-white mb-4">
                <?php echo $course->title; ?>
            </h2>
        </div>

        <!-- Course Modules -->
        <div class="space-y-2">
            <?php foreach ($modules as $module): ?>
                <div class="border-b border-gray-700">
                    <div class="p-4">
                        <h3 class="text-white font-medium">
                            <?php echo $module->title; ?>
                        </h3>
                    </div>
                    <div>
                        <?php foreach ($module->lessons as $lesson): ?>
                            <a href="<?php echo site_url('course/watch/' . $course->id . '/' . $lesson->id); ?>" 
                               class="flex items-center p-4 hover:bg-gray-700 transition-colors <?php echo ($current_lesson->id === $lesson->id) ? 'bg-gray-700' : ''; ?>">
                                
                                <?php if (isset($progress->completed_lessons[$lesson->id])): ?>
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                <?php else: ?>
                                    <i class="far fa-circle text-gray-500 mr-3"></i>
                                <?php endif; ?>
                                
                                <div class="flex-1">
                                    <p class="text-sm <?php echo ($current_lesson->id === $lesson->id) ? 'text-white' : 'text-gray-400'; ?>">
                                        <?php echo $lesson->title; ?>
                                    </p>
                                    <span class="text-xs text-gray-500">
                                        <?php echo $lesson->duration; ?> min
                                    </span>
                                </div>

                                <?php if ($lesson->has_material): ?>
                                    <a href="<?php echo site_url('course/download_material/' . $lesson->material_id); ?>" 
                                       class="text-gray-400 hover:text-white ml-2"
                                       title="Material complementar">
                                        <i class="fas fa-download"></i>
                                    </a>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-80">
        <!-- Video Player -->
        <div class="relative bg-black" style="padding-top: 56.25%">
            <div id="player" class="absolute inset-0"></div>
        </div>

        <!-- Lesson Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-white">
                    <?php echo $current_lesson->title; ?>
                </h1>
                
                <button id="complete-lesson" 
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors <?php echo isset($progress->completed_lessons[$current_lesson->id]) ? 'opacity-50 cursor-not-allowed' : ''; ?>"
                        <?php echo isset($progress->completed_lessons[$current_lesson->id]) ? 'disabled' : ''; ?>>
                    <?php echo isset($progress->completed_lessons[$current_lesson->id]) ? 'Aula Concluída' : 'Marcar como Concluída'; ?>
                </button>
            </div>

            <?php if ($current_lesson->description): ?>
                <div class="prose prose-invert max-w-none mb-8">
                    <?php echo $current_lesson->description; ?>
                </div>
            <?php endif; ?>

            <?php if ($current_lesson->has_material): ?>
                <div class="bg-gray-800 rounded-lg p-4 flex items-center justify-between">
                    <div>
                        <h3 class="text-white font-medium">Material Complementar</h3>
                        <p class="text-sm text-gray-400">
                            <?php echo $current_lesson->material_description; ?>
                        </p>
                    </div>
                    <a href="<?php echo site_url('course/download_material/' . $current_lesson->material_id); ?>" 
                       class="netflix-button inline-flex items-center">
                        <i class="fas fa-download mr-2"></i>
                        Baixar Material
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Video.js CSS -->
<link href="https://vjs.zencdn.net/7.20.3/video-js.css" rel="stylesheet" />

<!-- Video.js JavaScript -->
<script src="https://vjs.zencdn.net/7.20.3/video.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize video player
    const player = videojs('player', {
        controls: true,
        autoplay: false,
        preload: 'auto',
        fluid: true,
        playbackRates: [0.5, 1, 1.25, 1.5, 2],
        sources: [{
            src: '<?php echo $current_lesson->video_url; ?>',
            type: 'video/mp4'
        }]
    });

    // Save progress every 5 seconds
    let lastTime = 0;
    player.on('timeupdate', function() {
        const currentTime = Math.floor(player.currentTime());
        if (currentTime !== lastTime && currentTime % 5 === 0) {
            lastTime = currentTime;
            saveProgress(currentTime);
        }
    });

    // Load saved progress
    player.on('loadedmetadata', function() {
        const savedTime = <?php echo $current_lesson->progress_time ?? 0; ?>;
        if (savedTime > 0) {
            player.currentTime(savedTime);
        }
    });

    // Handle lesson completion
    const completeButton = document.getElementById('complete-lesson');
    if (completeButton) {
        completeButton.addEventListener('click', function() {
            if (!this.disabled) {
                completeLessonAjax();
            }
        });
    }

    // Save progress AJAX
    function saveProgress(time) {
        fetch('<?php echo site_url("course/update_progress_time"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                lesson_id: '<?php echo $current_lesson->id; ?>',
                time: time
            })
        });
    }

    // Complete lesson AJAX
    function completeLessonAjax() {
        fetch('<?php echo site_url("course/complete_lesson"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                lesson_id: '<?php echo $current_lesson->id; ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update button state
                completeButton.textContent = 'Aula Concluída';
                completeButton.disabled = true;
                completeButton.classList.add('opacity-50', 'cursor-not-allowed');

                // Update lesson icon in sidebar
                const lessonIcon = document.querySelector(`a[href*="${<?php echo $current_lesson->id; ?>}"] i`);
                if (lessonIcon) {
                    lessonIcon.className = 'fas fa-check-circle text-green-500 mr-3';
                }

                // Show completion message if course is completed
                if (data.completed) {
                    showCourseCompletedMessage();
                }
            }
        });
    }

    // Show course completion message
    function showCourseCompletedMessage() {
        const message = document.createElement('div');
        message.className = 'fixed inset-0 flex items-center justify-center z-50';
        message.innerHTML = `
            <div class="bg-gray-900 bg-opacity-50 absolute inset-0"></div>
            <div class="bg-gray-800 p-8 rounded-lg shadow-xl relative max-w-md mx-4">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-check text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">
                        Parabéns!
                    </h3>
                    <p class="text-gray-300 mb-6">
                        Você completou o curso com sucesso!
                    </p>
                    <div class="space-y-4">
                        <a href="<?php echo site_url('dashboard'); ?>" 
                           class="block w-full netflix-button text-center">
                            Voltar para Dashboard
                        </a>
                        <button onclick="this.parentElement.parentElement.parentElement.remove()" 
                                class="block w-full bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                            Continuar Assistindo
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(message);
    }
});
</script>