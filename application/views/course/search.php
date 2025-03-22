<div class="min-h-screen bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Search Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">
                <?php if ($search_query): ?>
                    Resultados para "<?php echo $search_query; ?>"
                <?php else: ?>
                    Explorar Cursos
                <?php endif; ?>
            </h1>
            <p class="mt-2 text-gray-400">
                <?php echo $total_courses; ?> cursos encontrados
            </p>
        </div>

        <!-- Search and Filters -->
        <div class="bg-gray-800 rounded-lg p-6 mb-8">
            <?php echo form_open('course/search', ['method' => 'GET', 'class' => 'space-y-4 md:space-y-0 md:flex md:space-x-4']); ?>
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="sr-only">Buscar cursos</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="q" 
                               id="search" 
                               value="<?php echo $search_query; ?>"
                               class="block w-full pl-10 pr-3 py-2 border border-gray-700 rounded-md leading-5 bg-gray-700 text-gray-300 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                               placeholder="Buscar cursos...">
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="w-full md:w-48">
                    <label for="category" class="sr-only">Categoria</label>
                    <select name="category" 
                            id="category"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-700 rounded-md leading-5 bg-gray-700 text-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Todas as categorias</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->id; ?>" 
                                    <?php echo $selected_category == $category->id ? 'selected' : ''; ?>>
                                <?php echo $category->name; ?> (<?php echo $category->total_courses; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Level Filter -->
                <div class="w-full md:w-48">
                    <label for="level" class="sr-only">Nível</label>
                    <select name="level" 
                            id="level"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-700 rounded-md leading-5 bg-gray-700 text-gray-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Todos os níveis</option>
                        <option value="iniciante" <?php echo $selected_level === 'iniciante' ? 'selected' : ''; ?>>
                            Iniciante
                        </option>
                        <option value="intermediario" <?php echo $selected_level === 'intermediario' ? 'selected' : ''; ?>>
                            Intermediário
                        </option>
                        <option value="avancado" <?php echo $selected_level === 'avancado' ? 'selected' : ''; ?>>
                            Avançado
                        </option>
                    </select>
                </div>

                <!-- Search Button -->
                <div class="w-full md:w-auto">
                    <button type="submit" 
                            class="w-full md:w-auto netflix-button inline-flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Buscar
                    </button>
                </div>
            <?php echo form_close(); ?>
        </div>

        <!-- Search Results -->
        <?php if (empty($courses)): ?>
            <div class="text-center py-12">
                <div class="mb-4">
                    <i class="fas fa-search text-4xl text-gray-600"></i>
                </div>
                <h3 class="text-xl font-medium text-white mb-2">
                    Nenhum curso encontrado
                </h3>
                <p class="text-gray-400">
                    Tente ajustar seus filtros ou buscar por outros termos
                </p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($courses as $course): ?>
                    <div class="bg-gray-800 rounded-lg overflow-hidden">
                        <div class="relative">
                            <img src="<?php echo $course->thumbnail; ?>" 
                                 alt="<?php echo $course->title; ?>"
                                 class="w-full h-48 object-cover">
                            
                            <?php if ($course->is_new): ?>
                                <div class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded">
                                    Novo
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-4">
                            <div class="flex items-center space-x-2 text-xs text-gray-400 mb-2">
                                <span class="bg-gray-700 px-2 py-1 rounded">
                                    <?php echo $course->category_name; ?>
                                </span>
                                <span class="bg-gray-700 px-2 py-1 rounded">
                                    <?php echo $course->level; ?>
                                </span>
                            </div>

                            <h3 class="text-lg font-medium text-white mb-2">
                                <?php echo $course->title; ?>
                            </h3>

                            <p class="text-sm text-gray-400 mb-4">
                                <?php echo character_limiter($course->description, 100); ?>
                            </p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img src="<?php echo $course->instructor_avatar; ?>" 
                                         alt="<?php echo $course->instructor_name; ?>"
                                         class="w-6 h-6 rounded-full mr-2">
                                    <span class="text-sm text-gray-400">
                                        <?php echo $course->instructor_name; ?>
                                    </span>
                                </div>
                                <div class="text-sm text-gray-400">
                                    <?php echo $course->duration; ?> horas
                                </div>
                            </div>

                            <a href="<?php echo site_url('course/detail/' . $course->id); ?>" 
                               class="mt-4 block w-full text-center netflix-button">
                                Ver Curso
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="mt-8 flex justify-center">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="<?php echo site_url('course/search?' . http_build_query(array_merge($_GET, ['page' => $i]))); ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-gray-700 text-sm font-medium 
                                      <?php echo $current_page == $i 
                                          ? 'bg-red-600 text-white border-red-600' 
                                          : 'bg-gray-800 text-gray-300 hover:bg-gray-700'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>