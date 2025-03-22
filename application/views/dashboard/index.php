<div class="min-h-screen bg-gray-900">
    <!-- Featured Course Banner -->
    <?php if (!empty($featured_courses)): ?>
        <?php $featured = $featured_courses[0]; ?>
        <div class="relative h-[70vh] w-full">
            <!-- Featured Background -->
            <div class="absolute inset-0">
                <img src="<?php echo $featured->thumbnail; ?>" 
                     alt="<?php echo $featured->title; ?>"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50"></div>
            </div>

            <!-- Featured Content -->
            <div class="absolute bottom-0 left-0 right-0 p-8 md:p-16">
                <div class="max-w-3xl">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        <?php echo $featured->title; ?>
                    </h1>
                    <p class="text-lg text-gray-300 mb-6">
                        <?php echo character_limiter($featured->description, 200); ?>
                    </p>
                    <div class="flex space-x-4">
                        <a href="<?php echo site_url('course/watch/' . $featured->id); ?>" 
                           class="netflix-button inline-flex items-center">
                            <i class="fas fa-play mr-2"></i>
                            Assistir Agora
                        </a>
                        <a href="<?php echo site_url('course/detail/' . $featured->id); ?>" 
                           class="bg-gray-800 bg-opacity-75 hover:bg-opacity-100 text-white px-6 py-2 rounded-md inline-flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Mais Informações
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="px-4 sm:px-6 lg:px-8 py-8 space-y-8">
        <!-- Continue Watching -->
        <?php if (!empty($continue_watching)): ?>
            <section>
                <h2 class="text-2xl font-bold text-white mb-4">
                    Continuar Assistindo
                </h2>
                <div class="relative">
                    <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                        <?php foreach ($continue_watching as $course): ?>
                            <div class="flex-none w-64">
                                <div class="relative group">
                                    <img src="<?php echo $course->thumbnail; ?>" 
                                         alt="<?php echo $course->title; ?>"
                                         class="w-full h-36 object-cover rounded-md">
                                    
                                    <!-- Progress Bar -->
                                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-700">
                                        <div class="h-full bg-red-600" 
                                             style="width: <?php echo $course->progress; ?>%"></div>
                                    </div>

                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity rounded-md flex items-center justify-center">
                                        <a href="<?php echo site_url('course/watch/' . $course->id); ?>" 
                                           class="text-white hover:text-red-600">
                                            <i class="fas fa-play-circle text-4xl"></i>
                                        </a>
                                    </div>
                                </div>
                                <h3 class="mt-2 text-white font-medium">
                                    <?php echo $course->title; ?>
                                </h3>
                                <p class="text-sm text-gray-400">
                                    <?php echo $course->category_name; ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Categories -->
        <?php foreach ($courses_by_category as $category_group): ?>
            <section>
                <h2 class="text-2xl font-bold text-white mb-4">
                    <?php echo $category_group['category']->name; ?>
                </h2>
                <div class="relative">
                    <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                        <?php foreach ($category_group['courses'] as $course): ?>
                            <div class="flex-none w-64">
                                <div class="relative group">
                                    <img src="<?php echo $course->thumbnail; ?>" 
                                         alt="<?php echo $course->title; ?>"
                                         class="w-full h-36 object-cover rounded-md">

                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity rounded-md flex items-center justify-center">
                                        <a href="<?php echo site_url('course/watch/' . $course->id); ?>" 
                                           class="text-white hover:text-red-600">
                                            <i class="fas fa-play-circle text-4xl"></i>
                                        </a>
                                    </div>
                                </div>
                                <h3 class="mt-2 text-white font-medium">
                                    <?php echo $course->title; ?>
                                </h3>
                                <p class="text-sm text-gray-400">
                                    <?php echo $course->instructor_name; ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endforeach; ?>

        <!-- Recommended Courses -->
        <?php if (!empty($recommended_courses)): ?>
            <section>
                <h2 class="text-2xl font-bold text-white mb-4">
                    Recomendados para Você
                </h2>
                <div class="relative">
                    <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                        <?php foreach ($recommended_courses as $course): ?>
                            <div class="flex-none w-64">
                                <div class="relative group">
                                    <img src="<?php echo $course->thumbnail; ?>" 
                                         alt="<?php echo $course->title; ?>"
                                         class="w-full h-36 object-cover rounded-md">

                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity rounded-md flex items-center justify-center">
                                        <a href="<?php echo site_url('course/watch/' . $course->id); ?>" 
                                           class="text-white hover:text-red-600">
                                            <i class="fas fa-play-circle text-4xl"></i>
                                        </a>
                                    </div>
                                </div>
                                <h3 class="mt-2 text-white font-medium">
                                    <?php echo $course->title; ?>
                                </h3>
                                <p class="text-sm text-gray-400">
                                    <?php echo $course->category_name; ?> • 
                                    <?php echo $course->level; ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- New Courses -->
        <?php if (!empty($new_courses)): ?>
            <section>
                <h2 class="text-2xl font-bold text-white mb-4">
                    Novos Cursos
                </h2>
                <div class="relative">
                    <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                        <?php foreach ($new_courses as $course): ?>
                            <div class="flex-none w-64">
                                <div class="relative group">
                                    <img src="<?php echo $course->thumbnail; ?>" 
                                         alt="<?php echo $course->title; ?>"
                                         class="w-full h-36 object-cover rounded-md">

                                    <!-- New Badge -->
                                    <div class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded">
                                        Novo
                                    </div>

                                    <!-- Hover Overlay -->
                                    <div class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity rounded-md flex items-center justify-center">
                                        <a href="<?php echo site_url('course/watch/' . $course->id); ?>" 
                                           class="text-white hover:text-red-600">
                                            <i class="fas fa-play-circle text-4xl"></i>
                                        </a>
                                    </div>
                                </div>
                                <h3 class="mt-2 text-white font-medium">
                                    <?php echo $course->title; ?>
                                </h3>
                                <p class="text-sm text-gray-400">
                                    Adicionado em <?php echo date('d/m/Y', strtotime($course->created_at)); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Hide scrollbar but keep functionality */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>