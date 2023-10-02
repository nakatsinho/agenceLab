<template>
    <aside class="left-sidebar">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- User profile -->
            <div class="user-profile">
                <!-- User profile image -->
                <div class="profile-img"> <img src="@/assets/images/users/1.jpg" alt="user" />
                    <!-- this is blinking heartbit-->
                    <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
                </div>
                <!-- User profile text-->
                <div class="profile-text">
                    <h5>Kelton M. Cumbe</h5>
                    <a href="#" class="" data-toggle="tooltip" title="Logout"><i
                            class="mdi mdi-power"></i></a>
                </div>
            </div>
            <!-- End User profile text-->
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <li class="nav-devider"></li>
                    <li class="nav-small-cap">MAIN MENU</li>
                    <li>
                        <router-link class="waves-effect waves-dark" to="/dashboard"><i
                                class="mdi mdi-gauge"></i>Painel de Controle</router-link>
                    </li>
                    <li>
                        <router-link class="waves-effect waves-dark" to="/consultant"><i
                                class="mdi mdi-bullseye"></i>Consultores</router-link>
                    </li>
                    <li>
                        <router-link class="waves-effect waves-dark" to="/client"><i
                                class="mdi mdi-table"></i>Clientes</router-link>
                    </li>
                    <li class="nav-small-cap">EXTRAS, PARAMS &amp; SETTINGS</li>
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i
                                class="mdi mdi-engine"></i><span class="hide-menu">Configuração</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#">Basic Forms</a></li>
                        </ul>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
export default {
    setup() {


        return {}
    }
}
</script>

<style lang="scss" scoped></style>