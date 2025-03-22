<div class="min-h-screen bg-gray-900">
    <!-- Course Header -->
    <div class="relative h-[50vh] w-full">
        <!-- Course Background -->
        <div class="absolute inset-0">
            <img src="<?php echo $course->thumbnail; ?>" 
                 alt="<?php echo $course->title; ?>"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50"></div>
        </div>

        <!-- Course Info -->
        <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16">
            <div class="max-w-4xl">
                <div class="flex items-center space-x-2 text-sm text-gray-300 mb-4">
                    <span class="bg-gray-800 px-2 py-1 rounded">
                        <?php echo $course->category_name; ?>
                    </span>
                    <span>•</span>
                    <span class="bg-gray-800 px-2 py-1 rounded">
                        <?php echo $course->level; ?>
                    </span>
                    <span>•</span>
                    <span class="bg-gray-800 px-2 py-1 rounded">
                        <?php echo $course->duration; ?> horas
                    </span>
                </div>

                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    <?php echo $course->title; ?>
                </h1>
                
                <p class="text-lg text-gray-300 mb-6">
                    <?php echo $course->description; ?>
                </p>

                <div class="flex items-center space-x-4">
                    <a href="<?php echo site_url('course/watch/' . $course->id); ?>" 
                       class="netflix-button inline-flex items-center">
                        <i class="fas fa-play mr-2"></i>
                        <?php echo $progress ? 'Continuar Curso' : 'Começar Curso'; ?>
                    </a>
                    
                    <?php if ($progress): ?>
                        <div class="text-gray-300">
                            <span class="font-medium"><?php echo $progress->percentage; ?>%</span> concluído
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Course Modules -->
            <div class="lg:col-span-2">
                <h2 class="text-2xl font-bold text-white mb-6">
                    Conteúdo do Curso
                </h2>

                <div class="space-y-4">
                    <?php foreach ($modules as $module): ?>
                        <div class="bg-gray-800 rounded-lg overflow-hidden">
                            <div class="p-4 flex items-center justify-between">
                                <h3 class="text-lg font-medium text-white">
                                    <?php echo $module->title; ?>
                                </h3>
                                <span class="text-sm text-gray-400">
                                    <?php echo count($module->lessons); ?> aulas
                                </span>
                            </div>

                            <div class="border-t border-gray-700">
                                <?php foreach ($module->lessons as $lesson): ?>
                                    <div class="p-4 flex items-center space-x-4 hover:bg-gray-700 transition-colors">
                                        <?php if (isset($progress->completed_lessons[$lesson->id])): ?>
                                            <i class="fas fa-check-circle text-green-500"></i>
                                        <?php else: ?>
                                            <i class="far fa-circle text-gray-500"></i>
                                        <?php endif; ?>
                                        
                                        <div class="flex-1">
                                            <a href="<?php echo site_url('course/watch/' . $course->id . '/' . $lesson->id); ?>" 
                                               class="text-gray-300 hover:text-white">
                                                <?php echo $lesson->title; ?>
                                            </a>
                                            <p class="text-sm text-gray-500">
                                                <?php echo $lesson->duration; ?> min
                                            </p>
                                        </div>

                                        <?php if ($lesson->has_material): ?>
                                            <a href="<?php echo site_url('course/download_material/' . $lesson->material_id); ?>" 
                                               class="text-gray-400 hover:text-white"
                                               title="Material complementar">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Course Info Sidebar -->
            <div>
                <div class="bg-gray-800 rounded-lg p-6 sticky top-4">
                    <div class="space-y-6">
                        <!-- Instructor -->
                        <div>
                            <h3 class="text-lg font-medium text-white mb-4">
                                Instrutor
                            </h3>
                            <div class="flex items-center space-x-4">
                                <img src="<?php echo $course->instructor_avatar; ?>" 
                                     alt="<?php echo $course->instructor_name; ?>"
                                     class="w-12 h-12 rounded-full">
                                <div>
                                    <h4 class="text-white font-medium">
                                        <?php echo $course->instructor_name; ?>
                                    </h4>
                                    <p class="text-sm text-gray-400">
                                        <?php echo $course->instructor_title; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div>
                            <h3 class="text-lg font-medium text-white mb-4">
                                Informações do Curso
                            </h3>
                            <ul class="space-y-3 text-gray-300">
                                <li class="flex items-center">
                                    <i class="fas fa-clock w-6 text-gray-500"></i>
                                    <span><?php echo $course->duration; ?> horas de conteúdo</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-video w-6 text-gray-500"></i>
                                    <span><?php echo $course->total_lessons; ?> aulas</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-signal w-6 text-gray-500"></i>
                                    <span>Nível <?php echo $course->level; ?></span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-certificate w-6 text-gray-500"></i>
                                    <span>Certificado de conclusão</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Requirements -->
                        <?php if (!empty($course->requirements)): ?>
                            <div>
                                <h3 class="text-lg font-medium text-white mb-4">
                                    Pré-requisitos
                                </h3>
                                <ul class="space-y-2 text-gray-300">
                                    <?php foreach ($course->requirements as $requirement): ?>
                                        <li class="flex items-start">
                                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                            <?php echo $requirement; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Courses -->
        <?php if (!empty($related_courses)): ?>
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-white mb-6">
                    Cursos Relacionados
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($related_courses as $related): ?>
                        <div class="bg-gray-800 rounded-lg overflow-hidden">
                            <img src="<?php echo $related->thumbnail; ?>" 
                                 alt="<?php echo $related->title; ?>"
                                 class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h3 class="text-white font-medium mb-2">
                                    <?php echo $related->title; ?>
                                </h3>
                                <p class="text-sm text-gray-400 mb-4">
                                    <?php echo $related->instructor_name; ?>
                                </p>
                                <a href="<?php echo site_url('course/detail/' . $related->id); ?>" 
                                   class="text-red-600 hover:text-red-500 text-sm font-medium">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>