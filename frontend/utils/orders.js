import axios from "axios";

export async function getTotalOrders(userId) {
    const params = { userId: userId, APP_API_KEY: process.env.APP_API_KEY };
    const resp = await axios.get(`${process.env.VUE_BACKEND_URL}orders/getOrders.php`, { params });
    return resp.data.data[0].TotalOrders;
}