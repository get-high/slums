import React, {useEffect} from 'react'
import {useDispatch, useSelector} from 'react-redux'
import {getSpots, getSpotSuccessStatus, getSpotLoadingStatus} from '../../slices/spotSlice'
import {fetchSpots} from '../../actions/spotActions'
import ReactPaginate from 'react-paginate'

const Spots = () => {

  const spots = useSelector(getSpots);
  const page = 1;
  const dispatch = useDispatch();
  const pageCount = 2;

  function Spots({ currentSpots }) {
    return (
        <div>
          {currentSpots &&
              currentSpots.map((item) => (
                  <div key={item.id}>
                    <h3>Item #{item.title}</h3>
                  </div>
              ))}
        </div>
    );
  }

    const handlePageClick = (event) => {
        const newOffset = (event.selected * itemsPerPage) % items.length;
        setItemOffset(newOffset);
    };

  useEffect(() => {
    if (spots.length === 0) {
      dispatch(fetchSpots(page))
    }
  }, [spots, dispatch]);

  return (
      <>
        <h1>Spots Manager</h1>

        <Spots currentSpots={spots} />

          <ReactPaginate
              breakLabel="..."
              nextLabel="next >"
              onPageChange={handlePageClick}
              pageCount={2}
              marginPagesDisplayed={2}
              pageRangeDisplayed={5}
              forcePage={2}
              previousLabel="< previous"
              renderOnZeroPageCount={null}
          />
      </>
  )
}

export default Spots
