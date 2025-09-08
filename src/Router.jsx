import {createBrowserRouter, RouterProvider} from "react-router-dom";
import HomeOne from "./components/HomeOne/index.jsx";
import HomeTwo from "./components/SkyviewSubsidiary/index.jsx";
import HomeThree from "./components/ArmeseSubsidiary/index.jsx";
import HomeFour from "./components/MsmslSubsidiary/index.jsx";
import HomeFive from "./components/KilowattSubsidiary/index.jsx";
import AboutUs from "./components/AboutUs/index.jsx";
import Career from "./components/AboutUs/Career.jsx";
import Services from "./components/ServicesPages/index.jsx";
import Projects from "./components/ProjectsPages/index.jsx";
import ProjectsDetails from "./components/ProjectsPages/ProjectsDetails.jsx";
import News from "./components/NewsPages/index.jsx";
import NewsDetails from "./components/NewsPages/NewsDetails.jsx";
import NewsType from "./components/NewsPages/NewsType.jsx";
import BoardMemberDetails from "./components/BoardMembersPages/BoardMemberDetails.jsx";
import ManagementTeamDetails from "./components/ManagementTeamPages/ManagementTeamDetails.jsx";
import Contact from "./components/ContactPages/Contact.jsx";
import Testimonial from "./components/TestimonialPages/Testimonial.jsx";
import ServicesDetails from "./components/ServicesPages/ServicesDetails.jsx";
import Pricing from "./components/PricingPages/index.jsx";
import BoardMember from "./components/BoardMembersPages/index.jsx";
import ManagementTeam from "./components/ManagementTeamPages/index.jsx";
import Layout from "./components/Helper/Layout.jsx";
import Faq from "./components/FaqPages/Faq.jsx";
import Error from "./components/ErrorPages/Error.jsx";
import Products from "./components/ShopPages/Products.jsx";
import ProductsSidebar from "./components/ShopPages/ProductsSidebar.jsx";
import ProductsDetails from "./components/ShopPages/ProductsDetails.jsx";
import Cart from "./components/ShopPages/Cart.jsx"
import Checkout from "./components/ShopPages/Checkout.jsx";

const router = createBrowserRouter([
  {
    path:'/',
    Component:Layout,
    children:[
      {
        index:true,
        element: <HomeOne />
      },
      {
        path: "/SkyView",
        element: <HomeTwo />
      },
      {
        path: "/Armese",
        element: <HomeThree />
      },
      {
        path: "/MSMSL",
        element: <HomeFour />
      },
      {
        path: "/Kilowatt-Engineering",
        element: <HomeFive />
      },
      {
        path: "/who-we-are",
        element: <AboutUs />
      },
      {
        path: "/what-we-do",
        element: <Services />
      },
      {
        path: "/careers",
        element: <Career />
      },
      {
        path: "/what-we-have-done",
        element: <Projects />
      },
      {
        path: "/what-we-have-done/project-details",
        element: <ProjectsDetails />
      },
      {
        path: "/shop-products",
        element: <Products />
      },
      {
        path: "/shop-cart",
        element: <Cart />
      },
      {
        path: "/shop-checkout",
        element: <Checkout />
      },
      {
        path: "/shop-products-sidebar",
        element: <ProductsSidebar />
      },
      {
        path: "/shop-product-details",
        element: <ProductsDetails />
      },
      {
        path: "/blog",
        element: <News />
      },
      {
        path: "/blog/:type/:name",
        element: <NewsType />
      },
      {
        path: "blog/details/:title",
        element: <NewsDetails />
      },
      {
        path: "/contact",
        element: <Contact />
      },
      {
        path: "/board-members",
        element: <BoardMember />
      },
      {
        path: "/management-team",
        element: <ManagementTeam />
      },
      {
        path: "/board-member/details/:title",
        element: <BoardMemberDetails />
      },
      {
        path: "/management-team/details/:title",
        element: <ManagementTeamDetails />
      },
      {
        path: "/page-testimonial",
        element: <Testimonial />
      },
      {
        path: "/getProject/details/:title",
        element: <ProjectsDetails />
      },
      {
        path: "/page-faq",
        element: <Faq />
      },
      {
        path: "/service/details/:title",
        element: <ServicesDetails />
      },
      {
        path: "/page-pricing",
        element: <Pricing />
      },
      {
        path: "*",
        element: <Error />
      },
    ]
  }
]);

function Router() {
  return (
    <>
      <RouterProvider router={router} />
    </>
  );
}

export default Router;
