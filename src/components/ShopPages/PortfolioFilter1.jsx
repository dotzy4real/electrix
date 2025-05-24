import { Link } from 'react-router-dom';
import { useEffect, useRef, useState } from "react";
import Isotope from 'isotope-layout';
import ProductImage1 from '/src/assets/images/resource/product/1.jpg';
import ProductImage2 from '/src/assets/images/resource/product/2.jpg';
import ProductImage3 from '/src/assets/images/resource/product/3.jpg';
import ProductImage4 from '/src/assets/images/resource/product/4.jpg';
import ProductImage5 from '/src/assets/images/resource/product/5.jpg';
import ProductImage6 from '/src/assets/images/resource/product/6.jpg';
import ProductImage7 from '/src/assets/images/resource/product/7.jpg';
import ProductImage8 from '/src/assets/images/resource/product/8.jpg';

export default function PortfolioFilter1() {
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
                {[ProductImage1, ProductImage2, ProductImage3, ProductImage4, ProductImage5, ProductImage6, ProductImage7, ProductImage8].map((image, index) => (
                    <div key={index} className={`product-block masonry-item small-column all cat-${index + 1} product lenses mb-50 col-lg-3 col-md-6 col-sm-12`}>
                        <div className="inner-box">
                            <div className="image-box">
                                <div className="image"><Link to="/shop-product-details"><img src={image} alt={`Product ${index + 1}`} /></Link></div>
                                <div className="icon-box">
                                    <Link to="/shop-product-details" className="ui-btn"><i className="fa fa-heart"></i></Link>
                                    <Link to="/shop-cart" className="ui-btn"><i className="fa fa-shopping-cart"></i></Link>
                                </div>
                            </div>
                            <div className="content">
                                <h4><Link to="/shop-product-details">Product {index + 1}</Link></h4>
                                <span className="price">${20 + index * 5}.00</span>
                                <span className="rating">{[...Array(5)].map((_, i) => <i key={i} className="fa fa-star"></i>)}</span>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </>
    );
}
