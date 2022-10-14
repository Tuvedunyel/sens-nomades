<?php
/*
 * Template Name: Home
 */
get_header();

$categories = get_the_category();
?>
<main class="blog" id="app">
    <section class="hero-banner">
        <div class="container-narrow">
            <h1>Les actualités <span>Sens nomades</span></h1>
        </div>
    </section>
    <article>
        <div class="container-narrow">
            <div class="most-recent-articles">
                <div v-if="loaded" class="card-container">
                    <div class="articles__card" v-for="post in recentArticles" :key="post.id">
                        <div class="card__thumbnail">
                            <img :src="post.media.large" alt="post.title">
                            <ul class="categories">
                                <li v-for="category in post.category_names">
                                    {{ category }}
                                </li>
                            </ul>
                        </div>
                        <div class="card__content">
                            <h3><a :href="post.permalink" v-html="post.title"></a></h3>
                            <p v-html="handlePostExcerpt(post)"></p>
                            <a :href="post.permalink">Lire la suite</a>
                        </div>
                    </div>
                </div>
                <div v-else class="card-container">
                    <div class="articles__card">
                        <div class="card__thumbnail">
                            <div class="img"></div>
                            <ul class="categories">
                                <li>
                                    Chargement...
                                </li>
                            </ul>
                        </div>
                        <div class="card__content">
                            <h3>Chargement...</h3>
                            <p>Chargement...</p>
                            <a href="#">Chargement...</a>
                        </div>
                    </div>
                </div>
            </div>
            <h2>Toutes les articles</h2>
            <div v-if="loaded" class="categories">
                <ul>
                    <li @click="handleClick(0, 'Tous les articles')" v-model="currentCategory"
                        :class="currentCategory === 'Tous les articles' && 'currentCat'">Tous
                        les
                        articles</li>
                    <li v-for="category in categories" :key="category.id" @click="handleClick(category.id, category
                    .name)" v-model="currentCategory" :class="currentCategory === category.name && 'currentCat'">
                        {{ category.name }}
                    </li>
                </ul>
            </div>
            <section v-if="loaded" class="articles">
                <div class="card-container">
                    <div class="articles__card" v-for="post in filteredPosts.slice(sliceA, sliceB)" :key="post.id">
                        <div class="card__thumbnail">
                            <img :src="post.media.large" alt="post.title">
                            <ul class="categories">
                                <li v-for="category in post.category_names">
                                    {{ category }}
                                </li>
                            </ul>
                        </div>
                        <div class="card__content">
                            <h3><a :href="post.permalink" v-html="post.title"></a></h3>
                            <p v-html="handlePostExcerpt(post)"></p>
                            <a :href="post.permalink">Lire la suite</a>
                        </div>
                    </div>
                </div>
                <div class="pagination" v-if="pagination.length > 1">
                    <button class="prev" @click="handleClickPrev">
                        <span class="screen-reader-text">Précédent</span>
                        <div class="prev-arrow"></div>
                    </button>
                    <button :class="page === currentPage ? 'page current' : 'page' " v-for="page in pagination"
                            :key="page" @click="changePage(page)">
                        {{ page }}
                    </button>
                    <button class="next" @click="handleClickNext">
                        <span class="screen-reader-text">Suivant</span>
                        <div class="next-arrow"></div>
                    </button>
                </div>
            </section>
            <section v-else class="articles">
                <div class="card-container">
                    <div class="articles__card">
                        <div class="card__thumbnail">
                            <div class="img"></div>
                            <ul class="categories">
                                <li>
                                    Chargement...
                                </li>
                            </ul>
                        </div>
                        <div class="card__content">
                            <h3>Chargement...</h3>
                            <p>Chargement...</p>
                            <a href="#">Chargement...</a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </article>
</main>

<script>
    const { createApp } = Vue

    createApp( {
        data () {
            return {
                siteUrl: 'https://www.sens-nomades.com',
                categories: [],
                posts: [],
                loaded: false,
                categoryId: 0,
                sliceA: 0,
                sliceB: 9,
                currentPage: 1,
                pagination: [],
                i: 1,
                numberOfPages: 0,
                step: 9,
                currentCategory: 'Tous les articles',
                currentUrl: window.location,
            }
        },
        computed: {
            filteredPosts () {
                if ( this.categoryId === 0 ) {
                    return this.posts
                } else {
                    return this.posts.filter( post => {
                        if ( post.category_ids.length > 0 ) {
                            return post.category_ids.includes( this.categoryId )
                        }
                    } )
                }
            },
            recentArticles () {
                return this.posts.slice( 0, 2 )
            },
        },
        async mounted () {
            await this.getUrl();
            await axios.get( `${this.siteUrl}/wp-json/wp/v2/categories` ).then( res => {
                this.categories = res.data
            } )
            await axios.get( `${this.siteUrl}/wp-json/better-rest-endpoints/v1/posts` ).then( res => {
                this.posts = res.data
            } )
            await this.checkCategories();
            this.numberOfPages = Math.ceil( this.posts.length / this.step );
            while ( this.i <= this.numberOfPages ) {
                this.pagination.push( this.i );
                this.i = this.i + 1;
            }
            this.loaded = true
        },
        methods: {
            checkCategories () {
                if ( this.currentUrl.search ) {
                    const urlParams = JSON.parse(this.currentUrl.search.replace('?', '').replaceAll('%22', '"'));
                    console.log(urlParams)
                    this.categoryId = urlParams.term_id;
                    this.currentCategory = urlParams.name.replaceAll('%C3%A9', 'é').replaceAll('%20', ' ');
                }
            },
            getUrl () {
                const url = new URL( window.location.href );
                this.siteUrl = url.origin
            },
            handleClick ( categoryId, name ) {
                this.currentCategory = name
                this.categoryId = categoryId
            },
            handleClickNext () {
                if ( this.sliceB < this.filteredPosts.length ) {
                    this.sliceA += this.step
                    this.sliceB += this.step
                    this.currentPage = this.currentPage + 1
                }
            },
            changePage ( pageNumber ) {
                if ( this.currentPage < pageNumber ) {
                    this.sliceA = this.sliceA + this.step * ( pageNumber - this.currentPage )
                    this.sliceB = this.sliceB + this.step * ( pageNumber - this.currentPage )
                    this.currentPage = pageNumber
                } else if ( this.currentPage > pageNumber ) {
                    this.sliceA = this.sliceA - this.step * ( this.currentPage - pageNumber )
                    this.sliceB = this.sliceB - this.step * ( this.currentPage - pageNumber )
                    this.currentPage = pageNumber
                }
            },
            handleClickPrev () {
                if ( this.sliceA > 0 ) {
                    this.sliceA -= this.step
                    this.sliceB -= this.step
                    this.currentPage = this.currentPage - 1
                }
            },
            handlePostExcerpt(post) {
                if (post.excerpt.length > 200) {
                    return post.excerpt.slice(0, 200) + '...'
                } else {
                    return post.excerpt
                }
            }
        }
    } ).mount( '#app' )
</script>

<?php get_footer(); ?>
