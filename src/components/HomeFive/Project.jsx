import React from 'react';
import { Link } from 'react-router-dom';
import ProjectImage1 from '../../assets/images/resource/product-img-1.jpg';
import ProjectImage2 from '../../assets/images/resource/product-img-2.jpg';
import ProjectImage3 from '../../assets/images/resource/product-img-3.jpg';
import ProjectImage4 from '../../assets/images/resource/product-img-4.jpg';

function Project({ className }) {
    return (
        <>
    <section id="projects" className={`products-section ${className || ''}`}>
		<div className="bg-pattern-7"/>
		<div className="auto-container">
			<div className="sec-title text-center">
				<span className="sub-title">OUR PRODUCTS</span>
				<h2>Our Latest Product</h2>
			</div>
			<div className="row">
				<div className="product-block col-lg-3 col-sm-6">
					<div className="inner-box">
						<div className="image"><Link to="/shop-product-details"><img src={ProjectImage1} alt="Image 01"/></Link></div>
						<div className="content">
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
							<h4><Link to="/shop-product-details">AC Repairing</Link></h4>
							<span className="price">$20.00</span>
						</div>
						<div className="icon-box">
							<Link to="/shop-product-details" className="ui-btn like-btn"><i className="fa fa-heart"></i></Link>
							<Link to="/shop-cart" className="ui-btn add-to-cart"><i className="fa fa-shopping-cart"></i></Link>
						</div>
					</div>
				</div>
				<div className="product-block col-lg-3 col-sm-6">
					<div className="inner-box">
						<div className="image"><Link to="/shop-product-details"><img src={ProjectImage2} alt="Image 02"/></Link></div>
						<div className="content">
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
							<h4><Link to="/shop-product-details">Home Maintenance</Link></h4>
							<span className="price">$27.00</span>
						</div>
						<div className="icon-box">
							<Link to="/shop-product-details" className="ui-btn like-btn"><i className="fa fa-heart"></i></Link>
							<Link to="/shop-cart" className="ui-btn add-to-cart"><i className="fa fa-shopping-cart"></i></Link>
						</div>
					</div>
				</div>
				<div className="product-block col-lg-3 col-sm-6">
					<div className="inner-box">
						<div className="image"><Link to="/shop-product-details"><img src={ProjectImage3} alt="Image 03"/></Link></div>
						<div className="content">
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
							<h4><Link to="/shop-product-details">Security System</Link></h4>
							<span className="price">$30.00</span>
						</div>
						<div className="icon-box">
							<Link to="/shop-product-details" className="ui-btn like-btn"><i className="fa fa-heart"></i></Link>
							<Link to="/shop-cart" className="ui-btn add-to-cart"><i className="fa fa-shopping-cart"></i></Link>
						</div>
					</div>
				</div>
				<div className="product-block col-lg-3 col-sm-6">
					<div className="inner-box">
						<div className="image"><Link to="/shop-product-details"><img src={ProjectImage4} alt="Image 04"/></Link></div>
						<div className="content">
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
							<h4><Link to="/shop-product-details">Industrial Maintenance </Link></h4>
							<span className="price">$15.00</span>
						</div>
						<div className="icon-box">
							<Link to="/shop-product-details" className="ui-btn like-btn"><i className="fa fa-heart"></i></Link>
							<Link to="/shop-cart" className="ui-btn add-to-cart"><i className="fa fa-shopping-cart"></i></Link>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
        </>
    );
}

export default Project;
