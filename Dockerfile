FROM node:18 as builder
WORKDIR /app
COPY . .
RUN cd frontend && npm install && npm run build
RUN cd backend && npm install

FROM node:18
WORKDIR /app
COPY --from=builder /app/backend ./backend
COPY --from=builder /app/frontend/build ./frontend/build
RUN npm install -g serve
EXPOSE 10000
EXPOSE 3000
CMD ["sh", "-c", "node backend/index.js & serve -s frontend/build -l 3000"]