// automatically generated by the FlatBuffers compiler, do not modify


#ifndef FLATBUFFERS_GENERATED_FRIDGEMEALCARDS_BS_H_
#define FLATBUFFERS_GENERATED_FRIDGEMEALCARDS_BS_H_

#include "flatbuffers/flatbuffers.h"

#include "buynshare_generated.h"

namespace bs {

inline const bs::FridgeMealCards *GetFridgeMealCards(const void *buf) {
  return flatbuffers::GetRoot<bs::FridgeMealCards>(buf);
}

inline bool VerifyFridgeMealCardsBuffer(
    flatbuffers::Verifier &verifier) {
  return verifier.VerifyBuffer<bs::FridgeMealCards>(nullptr);
}

inline void FinishFridgeMealCardsBuffer(
    flatbuffers::FlatBufferBuilder &fbb,
    flatbuffers::Offset<bs::FridgeMealCards> root) {
  fbb.Finish(root);
}

}  // namespace bs

#endif  // FLATBUFFERS_GENERATED_FRIDGEMEALCARDS_BS_H_