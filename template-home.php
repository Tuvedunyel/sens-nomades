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
                    <div class="articles__card" v-for="post in filteredPosts" :key="post.id">
                        <div class="card__thumbnail">
                            <img :src="post.media.thumbnail" alt="post.title">
                            <ul class="categories">
                                <li v-for="category in post.category_names">
                                    {{ category }}
                                </li>
                            </ul>
                        </div>
                        <div class="card__content">
                            <h3>{{ post.title }}</h3>
                            <p>{{ post.excerpt }}</p>
                            <a :href="post.permalink">Lire la suite</a>
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
                categoryId: 0
            }
        },
        computed: {
            filteredPosts () {
                if ( this.categoryId === 0 ) {
                    console.log("toto")
                    return this.posts
                } else {
                    console.log('id > 0')
                    return this.posts.filter( post => {
                        return post.category_ids.map( category => category.includes( this.categoryId ) )
                    } )
                }
            }
        },
        async mounted () {
            await axios.get( 'https://sens-nomades.test/wp-json/wp/v2/categories' ).then( res => {
                this.categories = res.data
            } )
            await axios.get( 'https://sens-nomades.test/wp-json/better-rest-endpoints/v1/posts' ).then( res => {
                this.posts = res.data
            } )
            this.loaded = true
        },
        methods: {
            handleClick ( categoryId ) {
                console.log( categoryId )
                this.categoryId = categoryId
            }
        }
    } ).mount( '#app' )
</script>

<?php get_footer(); ?>
