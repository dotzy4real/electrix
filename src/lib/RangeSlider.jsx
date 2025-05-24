import React, { useState } from 'react';
import Slider from 'rc-slider';
import 'rc-slider/assets/index.css';

const RangeSlider = () => {
  const [price, setPrice] = useState([0, 60]);

  const handleSliderChange = (value) => {
    setPrice(value);
  };

  return (
    <div className="range-slider clearfix">
      <div className="price-range-slider">
        <Slider
          range
          min={0}
          max={100}
          defaultValue={price}
          onChange={handleSliderChange}
          value={price}
        />
      </div>
      <div className="clearfix">
        <p>Price: {price[0]} - {price[1]}</p>
        <div className="input">
          <input
            type="text"
            className="property-amount"
            name="field-name"
            value={`$${price[0]} - $${price[1]}`}
            readOnly
          />
        </div>
        <input type="submit" value="Filter" />
      </div>
    </div>
  );
};

export default RangeSlider;
