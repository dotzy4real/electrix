import { Link } from 'react-router-dom';
import { useEffect, useRef, useState } from "react";
import Isotope from 'isotope-layout';
import ProductImage1 from '../../assets/images/resource/product/1.jpg';
import ProductImage2 from '../../assets/images/resource/product/2.jpg';
import ProductImage3 from '../../assets/images/resource/product/3.jpg';
import ProductImage4 from '../../assets/images/resource/product/4.jpg';
import ProductImage5 from '../../assets/images/resource/product/5.jpg';
import ProductImage6 from '../../assets/images/resource/product/6.jpg';
import ProductImage7 from '../../assets/images/resource/product/7.jpg';
import ProductImage8 from '../../assets/images/resource/product/8.jpg';

export default function PortfolioFilter2() {
    const isotopeContainer = useRef(null);
    const [filterKey, setFilterKey] = useState("*");
    const [isotopeInstance, setIsotopeInstance] = useState(null);

    useEffect(() => {
        if (isotopeContainer.current) {
            const instance = new Isotope(isotopeContainer.current, {
                itemSelector: ".masonry-item",
                percentPosition: true,
                masonry: {
                    columnWidth: ".masonry-item",
                },
                animationOptions: {
                    duration: 750,
                    easing: "linear",
                    queue: false,
                },
            });
            setIsotopeInstance(instance);
        }
    }, []);

    useEffect(() => {
        if (isotopeInstance) {
            isotopeInstance.arrange({ filter: filterKey === "*" ? "*" : `.${filterKey}` });
        }
    }, [filterKey, isotopeInstance]);

    const handleFilterKeyChange = (key) => () => {
        setFilterKey(key);
    };

    const activeBtn = (value) => (value === filterKey ? "filter active" : "filter");

    return (
        <>
            <div className="filters clearfix">
                <ul className="filter-tabs filter-btns clearfix">
					<li className={activeBtn("*")} onClick={handleFilterKeyChange("*")}> All </li>
                    <li className={activeBtn("cat-1")} onClick={handleFilterKeyChange("cat-1")}>Trends</li>
                    <li className={activeBtn("cat-2")} onClick={handleFilterKeyChange("cat-2")}>Business</li>
                    <li className={activeBtn("cat-3")} onClick={handleFilterKeyChange("cat-3")}>AC</li>
                    <li className={activeBtn("cat-4")} onClick={handleFilterKeyChange("cat-4")}>Delivery</li>
                    <li className={activeBtn("cat-5")} onClick={handleFilterKeyChange("cat-5")}>Transport</li>
                </ul>
            </div>
            <div className="items-container row" ref={isotopeContainer}>
                {/* Your product blocks here */}
                <div className="product-block masonry-item small-column all cat-2 product lenses mb-50 col-lg-4 col-md-6">
                    <div className="inner-box">
                        <div className="image-box">
                            <div className="image"><Link to="/shop-product-details"><img src={ProductImage1} alt="Product 1" /></Link></div>
                            <div className="icon-box">
                                <Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
                                <Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
                            </div>
                        </div>
                        <div className="content">
	                        <h4><Link to="/shop-product-details">1 Ton Portable Air Conditioner</Link></h4>
	                        <span className="price">$32.00</span>
                            <span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
                        </div>
                    </div>
                </div>
                <div className="product-block masonry-item small-column all cat-1 cat-2 product lenses mb-50 col-lg-4 col-md-6">
           		 	<div className="inner-box">
						<div className="image-box">
							<div className="image"><Link to="/shop-product-details"><img src={ProductImage2} alt="Product 2" /></Link></div>
							<div className="icon-box">
								<Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
								<Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
							</div>
						</div>
						<div className="content">
		                    <h4><Link to="/shop-product-details">2 Star Window Air Conditioner</Link></h4>
		                    <span className="price">$52.00</span>
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
						</div>
					</div>
				</div>
				<div className="product-block masonry-item small-column all cat-1 cat-2 cat-4 product lenses mb-50 col-lg-4 col-md-6">
					<div className="inner-box">
						<div className="image-box">
							<div className="image"><Link to="/shop-product-details"><img src={ProductImage3} alt="Product 3" /></Link></div>
							<div className="icon-box">
								<Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
								<Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
							</div>
						</div>
						<div className="content">
		                    <h4><Link to="/shop-product-details">5 Star Inverter Split Air Conditioner</Link></h4>
		                    <span className="price">$42.00</span>
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
						</div>
					</div>
				</div>
				<div className="product-block masonry-item small-column all cat-1 cat-3 product lenses mb-50 col-lg-4 col-md-6">
					<div className="inner-box">
						<div className="image-box">
							<div className="image"><Link to="/shop-product-details"><img src={ProductImage4} alt="Product 4" /></Link></div>
							<div className="icon-box">
								<Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
								<Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
							</div>
						</div>
						<div className="content">
	                    <h4><Link to="/shop-product-details">5 Star Window Air Conditioner</Link></h4>
	                    <span className="price">$22.00</span>
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
						</div>
					</div>
				</div>
				<div className="product-block masonry-item small-column all cat-1 cat-3 cat-5 product lenses mb-50 col-lg-4 col-md-6">
					<div className="inner-box">
						<div className="image-box">
							<div className="image"><Link to="/shop-product-details"><img src={ProductImage5} alt="Product 5" /></Link></div>
							<div className="icon-box">
								<Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
								<Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
							</div>
						</div>
						<div className="content">
	                    <h4><Link to="/shop-product-details">Air Conditioner with LED Light</Link></h4>
	                    <span className="price">$34.00</span>
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
						</div>
					</div>
				</div>
				<div className="product-block masonry-item small-column all cat-2 cat-3 cat-4 product lenses mb-50 col-lg-4 col-md-6">
					<div className="inner-box">
						<div className="image-box">
							<div className="image"><Link to="/shop-product-details"><img src={ProductImage6} alt="Product 6" /></Link></div>
							<div className="icon-box">
								<Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
								<Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
							</div>
						</div>
						<div className="content">
		                    <h4><Link to="/shop-product-details">Air Purifier with Remote</Link></h4>
		                    <span className="price">$25.00</span>
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
						</div>
					</div>
				</div>
				<div className="product-block masonry-item small-column all cat-1 cat-2 cat-5 product lenses mb-50 col-lg-4 col-md-6">
					<div className="inner-box">
						<div className="image-box">
							<div className="image"><Link to="/shop-product-details"><img src={ProductImage7} alt="Product 7" /></Link></div>
							<div className="icon-box">
								<Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
								<Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
							</div>
						</div>
						<div className="content">
		                    <h4><Link to="/shop-product-details">Air Purifier With Triple Method</Link></h4>
		                    <span className="price">$20.00</span>
							<span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>						
						</div>
					</div>
				</div>
				<div className="product-block masonry-item small-column all cat-1 cat-4 cat-5 product lenses mb-50 col-lg-4 col-md-6">
					<div className="inner-box">
						<div className="image-box">
							<div className="image"><Link to="/shop-product-details"><img src={ProductImage8} alt="Product 8" /></Link></div>
							<div className="icon-box">
								<Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
								<Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
							</div>
						</div>
			            <div className="content">
			                <h4><Link to="/shop-product-details">Dual Hose Portable Air Conditioner</Link></h4>
			                <span className="price">$40.00</span>
			                <span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
			            </div>
			        </div>
	    		</div>
				<div className="product-block masonry-item small-column all cat-1 cat-4 cat-5 product lenses mb-50 col-lg-4 col-md-6">
					<div className="inner-box">
						<div className="image-box">
							<div className="image"><Link to="/shop-product-details"><img src={ProductImage2} alt="Product 2" /></Link></div>
							<div className="icon-box">
								<Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
								<Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
							</div>
						</div>
			            <div className="content">
			                <h4><Link to="/shop-product-details">Refrigerator air Conditioner box</Link></h4>
			                <span className="price">$32.00</span>
			                <span className="rating"><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i><i className="fa fa-star"></i></span>
			            </div>
			        </div>
	    		</div>
            </div>
        </>
    );
}
