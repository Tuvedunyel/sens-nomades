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
                            <h3 v-html="post.title"></h3>
                            <p v-html="post.excerpt.slice(0, 200)"></p>
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
                    <li @click="handleClick(0)">Tous les articles</li>
                    <li v-for="category in categories" :key="category.id" @click="handleClick(category.id)">
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
                            <h3 v-html="post.title"></h3>
                            <p v-html="post.excerpt.slice(0, 200)"></p>
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
                step: 9
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
            await axios.get( 'https://sens-nomades.com/wp-json/wp/v2/categories' ).then( res => {
                this.categories = res.data
            } )
            await axios.get( 'https://sens-nomades.com/wp-json/better-rest-endpoints/v1/posts' ).then( res => {
                this.posts = res.data
            } )
            this.numberOfPages = Math.ceil( this.posts.length / this.step );
            while ( this.i <= this.numberOfPages ) {
                this.pagination.push( this.i );
                this.i = this.i + 1;
            }
            this.loaded = true
        },
        methods: {
            handleClick ( categoryId ) {
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
            }
        }
    } ).mount( '#app' )
</script>

<?php get_footer(); ?>
