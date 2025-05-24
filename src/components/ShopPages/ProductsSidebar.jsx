import React from 'react';
import { Link } from 'react-router-dom';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import RangeSlider from '../../lib/RangeSlider2.jsx';
import PortfolioFilter2 from './PortfolioFilter2.jsx';
import ProductDetailsImg1 from '../../assets/images/resource/product/thumb-1.jpg';
import ProductDetailsImg2 from '../../assets/images/resource/product/thumb-2.jpg';
import ProductDetailsImg3 from '../../assets/images/resource/product/thumb-3.jpg';

function Products() {

    return (
        <>
				<InnerHeader />

				<PageTitle
	        title="Shop"
	        breadcrumb={[
	            { link: '/', title: 'Home' },
	            { link: '/products-sidebar', title: 'Products Sidebar' },
	        ]}
	     />
        <section className="featured-products">
			<div className="auto-container">
				<div className="row clearfix">
					<div className="col-lg-3">
						<div className="shop-sidebar">
							<div className="sidebar-search">
								<form action="/shop-products-sidebar" method="get" className="search-form">
									<div className="form-group">
										<input type="search" name="search-field" placeholder="Search..." />
										<button><i className="lnr lnr-icon-search"></i></button>
									</div>
								</form>
							</div>
							<div className="sidebar-widget category-widget">
								<div className="widget-title">
									<h5 className="widget-title">Categories</h5>
								</div>
								<div className="widget-content">
									<ul className="category-list clearfix">
										<li><Link to="/shop-product-details">HVAC</Link></li>
										<li><Link to="/shop-product-details">Installation</Link></li>
										<li><Link to="/shop-product-details">Repairing</Link></li>
										<li><Link to="/shop-product-details">Air Quality</Link></li>
										<li><Link to="/shop-product-details">Thermal</Link></li>
										<li><Link to="/shop-product-details">Checkup</Link></li>
									</ul>
								</div>
							</div>
							<div className="sidebar-widget price-filters">
								<div className="widget-title">
									<h5 className="widget-title">Filter by Price</h5>
								</div>
								<RangeSlider/>
							</div>
							<div className="sidebar-widget post-widget">
								<div className="widget-title">
									<h5 className="widget-title">Popular Products</h5>
								</div>
								<div className="post-inner">
									<div className="post">
										<figure className="post-thumb"><Link to="/shop-product-details"><img src={ProductDetailsImg1} alt="Product Thumb" /></Link></figure>
										<Link to="/shop-product-details">Portable AC</Link>
										<span className="price">$45.00</span>
									</div>
									<div className="post">
										<figure className="post-thumb"><Link to="/shop-product-details"><img src={ProductDetailsImg2} alt="Product Thumb" /></Link></figure>
										<Link to="/shop-product-details">Dual Hose</Link>
										<span className="price">$34.00</span>
									</div>
									<div className="post">
										<figure className="post-thumb"><Link to="/shop-product-details"><img src={ProductDetailsImg3} alt="Product Thumb" /></Link></figure>
										<Link to="/shop-product-details">Window AC</Link>
										<span className="price">$29.00</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div className="col-lg-9 content-side">
						<div className="mixitup-gallery">
							<PortfolioFilter2 />
						</div>
					</div>
				</div>
			</div>
		</section>
        <Footer />
		<BackToTop />
        </>
    );
}

export default Products;
