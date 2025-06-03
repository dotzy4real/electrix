import React from 'react';
import { Link } from 'react-router-dom';

function Navigation() {
    return (
      <nav className="nav main-menu">
            <ul className="navigation">
              
           <li><Link to="/">Home</Link>
              </li>
              
               {/*<li className="current dropdown"><Link to="/">Home</Link>
                <ul>
                  <li><Link to="/">Home page 01</Link></li>
                  <li><Link to="/index-2">Home page 02</Link></li>
                  <li><Link to="/index-3">Home page 03</Link></li>
                  <li><Link to="/index-4">Home page 04</Link></li>
                  <li><Link to="/index-5">Home page 05</Link></li>
                </ul>
              </li>*/}
        <li className="dropdown">
          <Link to="#">About Us</Link>
          <ul>
            <li><Link to="/who-we-are">Who We Are</Link></li>
            {/*<li className="dropdown">
              <Link to="#">Team</Link>
              <ul>
                <li><Link to="/page-team">Team List</Link></li>
                <li><Link to="/page-team-details">Team Details</Link></li>
              </ul>
            </li>
            <li className="dropdown">
              <Link to="#">Shop</Link>
              <ul>
                <li><Link to="/shop-products">Products</Link></li>
                <li><Link to="/shop-products-sidebar">Products with Sidebar</Link></li>
                <li><Link to="/shop-product-details">Product Details</Link></li>
                <li><Link to="/shop-cart">Cart</Link></li>
                <li><Link to="/shop-checkout">Checkout</Link></li>
              </ul>
            </li>
            <li><Link to="/page-faq">FAQ</Link></li>
            <li><Link to="/page-404">Page 404</Link></li>*/}
            <li><Link to="/board-members">Board Members</Link></li>
            <li><Link to="/management-team">Management Team</Link></li>
            <li><Link to="/careers">Careers</Link></li>
          </ul>
        </li>
              <li className="dropdown"><Link to="#">Services</Link>
                <ul>
                  <li><Link to="/what-we-do">What We Do</Link></li>
                  <li><Link to="/what-we-have-done">What We Have Done</Link></li>
                </ul>
              </li>
              {/* 
              <li className="dropdown"><Link to="#">Projects</Link>
                <ul>
                  <li><Link to="/page-projects">Projects List</Link></li>
                  <li><Link to="/page-project-details">Project Details</Link></li>
                </ul>
              </li>*/}
              <li className="dropdown"><Link to="#">Subsidiaries</Link>
                <ul>
                  <li><Link to="/Armese">Armese</Link></li>
                  <li><Link to="/Kilowatt-Engineering">Kilowatt Engineering</Link></li>
                  <li><Link to="/MSMSL">MSMSL</Link></li>
                  <li><Link to="/SkyView">Skyview</Link></li>
                </ul>
              </li>
              {/*<li className="dropdown"><Link to="#">Blog</Link>
                  <ul>
                    <li><Link to="/news-grid">News Grid</Link></li>
                    <li><Link to="/news-details">News Details</Link></li>
                  </ul>
                <div className="dropdown-btn"><i className="fa fa-angle-down"></i></div></li>*/}
              <li><Link to="/blog">Blog</Link></li>
              <li><Link to="/contact">Contact</Link></li>
            </ul>
      </nav>
    );
}

export default Navigation;
