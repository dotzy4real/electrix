import React, { useLayoutEffect, useRef, useState } from "react"; // Combined imports
import { Link } from 'react-router-dom';
import BackToTop from '../BackToTop.jsx';
import { Swiper, SwiperSlide } from "swiper/react";
import { FreeMode, Navigation, Autoplay, Thumbs } from 'swiper/modules';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import ProductDetailsImg1 from '../../assets/images/resource/product/product-details.jpg';
import ProductDetailsImg2 from '../../assets/images/resource/product/product-details2.jpg';
import ProductDetailsImg3 from '../../assets/images/resource/product/product-details3.jpg';
import ThumbImg1 from '../../assets/images/resource/product/product-details.jpg';
import ThumbImg2 from '../../assets/images/resource/product/product-details2.jpg';
import ThumbImg3 from '../../assets/images/resource/product/product-details3.jpg';
import ThumbRattingImg1 from '../../assets/images/resource/testi1-1.jpg';
import ThumbRattingImg2 from '../../assets/images/resource/testi1-2.jpg';
import ProductImage1 from '../../assets/images/resource/product/1.jpg';
import ProductImage2 from '../../assets/images/resource/product/2.jpg';
import ProductImage3 from '../../assets/images/resource/product/3.jpg';
import ProductImage4 from '../../assets/images/resource/product/4.jpg';

function ProductsDetails() {
    const [activeIndex, setActiveIndex] = useState(1);
    const handleOnClick = (index) => {
        setActiveIndex(index);
    };

    const [thumbsSwiper, setThumbsSwiper] = useState(null);
    const [quantities, setQuantities] = useState({
        item1: 1,
        item2: 1,
        item3: 1
    });

    const handleQuantityChange = (item, change) => {
        setQuantities(prevQuantities => {
            const newQuantity = prevQuantities[item] + change;
            return {
                ...prevQuantities,
                [item]: newQuantity > 0 ? newQuantity : 1
            };
        });
    };


	const products = [
	    {
	      	id: 1,
	      	image: ProductImage1,
	      	name: "1 Ton Portable Air Conditioner",
	      	price: "$32.00",
	    },
	    {
	      	id: 2,
	      	image: ProductImage2,
	      	name: "2 Star Window Air Conditioner",
	      	price: "$52.00",
	    },
	    {
	      	id: 3,
	      	image: ProductImage3,
	      	name: "5 Star Inverter Split Air Conditioner",
	      	price: "$42.00",
	    },
	    {
	      	id: 4,
	      	image: ProductImage4,
	      	name: "5 Star Window Air Conditioner",
	      	price: "$22.00",
	    },
	];

    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Product Details"
                breadcrumb={[
                    { Link: '/', title: 'Home' },
                    { Link: '/products-details', title: 'Products Details' },
                ]}
            />
			<section className="product-details">
				<div className="container">
					<div className="row">
						<div className="col-lg-6 col-xl-6 mb-5 mb-lg-0">
							<div className="bxslider z-index-0">
								<div className="slider-content">
									<Swiper
										spaceBetween={10}
										pagination={{ clickable: true }}
										thumbs={{ swiper: thumbsSwiper && !thumbsSwiper.destroyed ? thumbsSwiper : null }}
										modules={[FreeMode, Navigation, Autoplay, Thumbs]}
										loop={true}
										autoplay={{
											delay: 3500,
											disableOnInteraction: false,
										}}
										className="slider-pager">
										<SwiperSlide><div className="image-box"><img src={ProductDetailsImg1} alt="Product Details" /></div></SwiperSlide>
										<SwiperSlide><div className="image-box"><img src={ProductDetailsImg2} alt="Product Details" /></div></SwiperSlide>
										<SwiperSlide><div className="image-box"><img src={ProductDetailsImg3} alt="Product Details" /></div></SwiperSlide>
									</Swiper>
									<Swiper
										onSwiper={setThumbsSwiper}
										spaceBetween={10}
										slidesPerView={5}
										freeMode={true}
										watchSlidesProgress={true}
										modules={[FreeMode, Navigation, Thumbs]}
										className="slider-pager">
										<SwiperSlide className="product-thumb wide-100">
											<figure className="image">
											<img src={ThumbImg1} alt="Product Thumb" />
											</figure>
										</SwiperSlide>
										<SwiperSlide className="product-thumb wide-100">
											<figure className="image">
											<img src={ThumbImg2} alt="Product Thumb" />
											</figure>
										</SwiperSlide>
										<SwiperSlide className="product-thumb wide-100">
											<figure className="image">
											<img src={ThumbImg3} alt="Product Thumb" />
											</figure>
										</SwiperSlide>
									</Swiper>
								</div>
							</div>
						</div>
						<div className="col-lg-6 col-xl-6">
							<div className="product-details__top">
								<h3 className="product-details__title">1 Ton Portable Air Conditioner <span>$96.00</span> </h3>
							</div>
							<div className="product-details__reveiw">
								<i className="fa fa-star"></i>
								<i className="fa fa-star"></i>
								<i className="fa fa-star"></i>
								<i className="fa fa-star"></i>
								<i className="fa fa-star"></i>
								<span className="ms-2">2 Customer Reviews</span>
							</div>
							<div className="product-details__content">
								<p className="product-details__content-text1">Aliquam hendrerit a augue insuscipit. Etiam aliquam massa quis des mauris commodo venenatis ligula commodo leez sed blandit convallis dignissim onec vel pellentesque neque.</p>
								<p className="product-details__content-text2"><strong>REF.</strong> 4231/406 <br/>Available in store</p>
							</div>
							<div className="product-details__quantity mb-4">
								<h3 className="product-details__quantity-title mb-0">Choose quantity</h3>
								<div className="quantity-box ms-3">
									<button type="button" className="sub" onClick={() => handleQuantityChange('item1', -1)}>
                                        <i className="fa fa-minus"></i>
                                    </button>
                                    <input type="number" id="1" value={quantities.item1} readOnly />
                                    <button type="button" className="add" onClick={() => handleQuantityChange('item1', 1)}>
                                        <i className="fa fa-plus"></i>
                                    </button>
								</div>
							</div>
							<div className="product-details__buttons d-flex align-items-center mb-4">
								<div className="product-details__buttons-1 mb-10 mb-sm-0 me-3">
									<Link to="/shop-cart" className="theme-btn btn-style-two"><span className="btn-title">Add to Cart</span></Link>
								</div>
								<div className="product-details__buttons-2 mb-10">
									<Link to="/shop-product-details" className="theme-btn btn-style-two"><span className="btn-title">Add to Wishlist</span></Link>
								</div>
							</div>
							<div className="product-details__social d-flex align-items-center">
								<div className="title"><h3 className="mb-0">Share with friends</h3></div>
								<ul className="social-icon-one ms-4">
									<li><Link to="#"><i className="fab fa-twitter"></i></Link></li>
									<li><Link to="#"><i className="fab fa-facebook-f"></i></Link></li>
									<li><Link to="#"><i className="fab fa-pinterest"></i></Link></li>
									<li><Link to="#"><i className="fab fa-instagram"></i></Link></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section className="product-description">
				<div className="container pt-0 pb-90">
					<div className="product-discription">
						<div className="tabs-box">
                            <div className="tab-btn-box text-center">
                                <ul className="tab-btns tab-buttons clearfix">
                                    <li className={activeIndex === 1 ? "tab-btn active-btn" : "tab-btn"} onClick={() => handleOnClick(1)} data-tab="#tab1">Description</li>
                                    <li className={activeIndex === 2 ? "tab-btn active-btn" : "tab-btn"} onClick={() => handleOnClick(2)} data-tab="#tab2">Reviews</li>
                                </ul>
                            </div>
                            <div className="tabs-content">
                                <div className={activeIndex === 1 ? "tab active-tab" : "tab"} id="tab1">
	                                <div className="text">
										<h3 className="product-description__title">Description</h3>
										<p className="product-description__text1">Lorem ipsum dolor sit amet, cibo mundi ea duo, vim exerci phaedrum. There are many variations of passages of Lorem Ipsum available, but the majority have alteration in some injected or words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrang hidden in the middle of text.</p>
										<div className="product-description__list">
											<ul className="list-unstyled">
												<li><p><span className="fa fa-arrow-right"></span> Nam at elit nec neque suscipit gravida.</p></li>
												<li><p><span className="fa fa-arrow-right"></span> Aenean egestas orci eu maximus tincidunt.</p></li>
												<li><p><span className="fa fa-arrow-right"></span> Curabitur vel turpis id tellus cursus laoreet.</p></li>
											</ul>
										</div>
										<p className="product-description__tex2">All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable.</p>
									</div>
                                </div>
                                <div className={activeIndex === 2 ? "tab active-tab" : "tab"} id="tab2">
	                                <div className="customer-comment">
										<div className="row clearfix">
											<div className="col-lg-6 col-md-6 col-sm-12 comment-column">
												<div className="single-comment-box">
													<div className="inner-box">
														<figure className="comment-thumb"><img src={ThumbRattingImg1} alt="Product Thumb" /></figure>
														<div className="inner">
															<ul className="rating clearfix">
																<li><i className="fas fa-star"></i></li>
																<li><i className="fas fa-star"></i></li>
																<li><i className="fas fa-star"></i></li>
																<li><i className="fas fa-star"></i></li>
																<li><i className="fas fa-star"></i></li>
															</ul>
															<h5>Jon D. William, <span>10 Jan, 2023 . 4:00 pm</span></h5>
															<p>Aliquam hendrerit a augue insuscipit. Etiam aliquam massa quis des mauris commodo.</p>
														</div>
													</div>
												</div>
											</div>
											<div className="col-lg-6 col-md-6 col-sm-12 comment-column">
												<div className="single-comment-box">
													<div className="inner-box">
														<figure className="comment-thumb"><img src={ThumbRattingImg2} alt="Product Thumb" /></figure>
														<div className="inner">
															<ul className="rating clearfix">
																<li><i className="fas fa-star"></i></li>
																<li><i className="fas fa-star"></i></li>
																<li><i className="fas fa-star"></i></li>
																<li><i className="fas fa-star"></i></li>
																<li><i className="fas fa-star"></i></li>
															</ul>
															<h5>Aleesha Brown, <span>12 Feb, 2023 . 8:00 pm</span></h5>
															<p>Aliquam hendrerit a augue insuscipit. Etiam aliquam massa quis des mauris commodo.</p>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div className="comment-box">
										<h3>Add Your Comments</h3>
										<form id="contact_form" name="contact_form" action="/shop-product-details" method="get">
											<div className="mb-3">
												<textarea name="form_message" className="form-control required" rows="7" placeholder="Enter Message"></textarea>
											</div>
											<div className="row">
												<div className="col-sm-6">
													<div className="mb-3">
														<input name="form_name" className="form-control" type="text" placeholder="Enter Name" />
													</div>
												</div>
												<div className="col-sm-6">
													<div className="mb-3">
														<input name="form_email" className="form-control required email" type="email" placeholder="Enter Email" />
													</div>
												</div>
											</div>
											<div className="col-lg-12 col-md-12 col-sm-12 column">
												<div className="review-box clearfix">
													<p>Your Review</p>
													<ul className="rating clearfix">
														<li><i className="far fa-star"></i></li>
														<li><i className="far fa-star"></i></li>
														<li><i className="far fa-star"></i></li>
														<li><i className="far fa-star"></i></li>
														<li><i className="far fa-star"></i></li>
													</ul>
												</div>
											</div>
											<div className="col-lg-12 col-md-12 col-sm-12 column">
												<div className="form-group clearfix">
													<div className="custom-controls-stacked">
														<label className="custom-control material-checkbox">
															<input type="checkbox" className="material-control-input" />
															<span className="material-control-indicator"></span>
															<span className="description"> Save my name, email, and website in this browser for the next time I comment.</span>
														</label>
													</div>
												</div>
											</div>
											<div className="mb-3">
												<input name="form_botcheck" className="form-control" type="hidden" />
												<button type="submit" className="theme-btn btn-style-two" data-loading-text="Please wait..."><span className="btn-title">Submit Comment</span></button>
											</div>
										</form>
									</div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</section>

			<section className="related-product">
		      	<div className="container pt-0 pb-90">
		        	<h3>Related Products</h3>
		        	<div className="row clearfix">
		          <div className="col">
		            <div className="mixitup-gallery">
		              <div className="filter-list row">
		                {products.map((product) => (
		                  <div
		                    key={product.id}
		                    className="product-block masonry-item small-column all cat-1 cat-2 product lenses mb-50 col-lg-3 col-md-6 col-sm-12"
		                  >
		                    <div className="inner-box">
		                      <div className="image-box">
		                        <div className="image">
		                          <Link to="/products-details">
		                            <img src={product.image} alt={product.name} />
		                          </Link>
		                        </div>
		                        <div className="icon-box">
		                          <Link to="/products-details" className="ui-btn">
		                            <i className="fa fa-heart"></i>
		                          </Link>
		                          <Link to="/cart" className="ui-btn">
		                            <i className="fa fa-shopping-cart"></i>
		                          </Link>
		                        </div>
		                      </div>
		                      <div className="content">
		                        <h4>
		                          <Link to="/products-details">{product.name}</Link>
		                        </h4>
		                        <span className="price">{product.price}</span>
		                        <span className="rating">
		                          <i className="fa fa-star"></i>
		                          <i className="fa fa-star"></i>
		                          <i className="fa fa-star"></i>
		                          <i className="fa fa-star"></i>
		                          <i className="fa fa-star"></i>
		                        </span>
		                      </div>
		                    </div>
		                  </div>
		                ))}
		              </div>
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

export default ProductsDetails;
